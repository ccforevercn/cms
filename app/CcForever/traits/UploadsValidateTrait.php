<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/21
 */
namespace App\CcForever\traits;

use Illuminate\Support\Facades\Storage;

/**
 * 上传文件
 *
 * Trait UploadsValidateTrait
 * @package App\CcForever\traits
 */
trait UploadsValidateTrait
{
    //上传图片格式限制
    private static $imageValidateExt = ['jpg' ,'jpeg' ,'png' ,'gif'];

    //上传图片的Mime类型限制
    private static $imageValidateMime = ['image/jpeg' ,'image/gif' ,'image/png'];

    //上传图片的大小限制
    private static $imageValidateSize = 2097152;

    // 文件内容非法字符检测
    private static $ILLEGAL_CHAR = ['php', 'eval', 'system', 'jsp', 'net'];

    /**
     * 检测非法字符
     *
     * @param object $file
     * @return bool
     */
    private static function illegalCharacter(object $file): bool
    {
        $fp=fopen($file->getPathname(),'r');
        ob_clean();
        flush();
        $stream = fread($fp, $file->getSize());
        fclose($fp);
        foreach (self::$ILLEGAL_CHAR as &$value){
            if(strpos($stream, $value)){
                return false;
            }
        }
        return true;
    }

    /**
     * 文件上传
     *
     * @param object $file
     * @param string $path
     * @return array
     * @throws \Exception
     */
    protected static function upload(object $file, string $path): array
    {
        $result = self::illegalCharacter($file);
        if(!$result){
            throw new \Exception('上传图片文件有非法字符');
        }
        // 获取上传文件名称
        $originalName = $file->getClientOriginalName();

        // 获取上传文件后缀
        $ext = $file->getClientOriginalExtension();

        // 判断上传图片文件类型
        if(!in_array($ext, self::$imageValidateExt)){
            throw new \Exception('上传文件图片格式错误：'. $ext);
        }

        // 获取上传文件路径
        $realPath = $file->getRealPath();

        // 获取上传文件的Mime类型
        $mimeType = $file->getClientMimeType();

        // 判断上传图片文件Mime类型
        if(!in_array($mimeType, self::$imageValidateMime)){
            throw new \Exception('上传文件图片Mime格式错误：'. $ext);
        }

        // 获取上传图片文件大小
        $size = $file->getSize();
        if(self::$imageValidateSize < $size){
            throw new \Exception('上传文件图片大小不能超过：'. self::$imageValidateSize);
        }

        // 获取上传图片路径
        $directorySeparator = '/';
        $newFilePath = make_time_path($path, 2, $directorySeparator);
        $newFileName = $newFilePath . md5(create_millisecond()). '.' . $ext;
        //上传图片
        if (Storage::disk('upload')->put($newFileName, file_get_contents($realPath))) {
            return ['name' => $originalName, 'path'=> $directorySeparator .'upload'. $newFileName];
        }
        throw new \Exception('上传文件图片失败！！！');
    }

    /**
     * 文件删除
     *
     * @param string $path
     * @return bool
     */
    protected static function remove(string $path): bool
    {
        // 数据库记录删除完成
        try{
            $path = str_replace('/upload', '', $path);
            Storage::disk('upload')->delete($path);
            return true;
        }catch(\Exception $exception){
            return false;
        }
    }

}