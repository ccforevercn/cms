<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/21
 */

namespace App\Repositories;

use App\CcForever\interfaces\RepositoryInterface;
use App\CcForever\traits\RepositoryReturnMsgData;
use App\CcForever\traits\UploadsValidateTrait;
use App\Uploads;
use function PHPSTORM_META\type;

/**
 * 文件上传
 *
 * Class UploadsRepository
 * @package App\Repositories
 */
class UploadsRepository implements RepositoryInterface
{
     use RepositoryReturnMsgData,UploadsValidateTrait;

    public function __construct(Uploads $model = null)
    {
        if(is_null($model)){
            self::loading();
        }else{
            self::$model = $model;
        }
    }

    /**
     * 手动加载Model
     */
    private static function loading(): void
    {
        self::$model = new Uploads();
    }

    /**
     * 上传文件列表
     *
     * @param array $where
     * @param int $page
     * @param int $limit
     * @return bool
     */
    public static function lst(array $where, int $page, int $limit): bool
    {
        // TODO: Implement lst() method.
        $where['admin_id'] = array_key_exists('admin_id', $where) && !is_null($where['admin_id']) ? (int)$where['admin_id'] : '';
        $offset = page_to_offset($page, $limit); // 获取起始值
        $list = self::$model::lst($where, $offset, $limit);// 上传文件列表
        return self::setMsg('上传文件列表', true, $list);
    }

    /**
     * 上传文件总数
     *
     * @param array $where
     * @return bool
     */
    public static function count(array $where): bool
    {
        // TODO: Implement count() method.
        $where['admin_id'] = array_key_exists('admin_id', $where) && !is_null($where['admin_id']) ? (int)$where['admin_id'] : '';
        $count = self::$model::count($where);// 上传文件总数
        return self::setMsg('上传文件总数', true, [$count]);
    }

    /**
     * 上传文件添加
     *
     * @param array $data
     * @return bool
     */
    public static function insert(array $data): bool
    {
        // TODO: Implement insert() method.
        $upload = [];
        $adminId = $data['admin_id'];
        $file = array_key_exists('file', $data) && !is_null($data['file']) ? $data['file'] : null;
        $path = array_key_exists('path', $data) && !is_null($data['path']) ? $data['path'] : null;
        if(!check_null($file, $path)){
            return self::setMsg('上传文件不存在', false);
        }
        try{
            $data = self::upload($file, $path);
            $upload['path'] = $data['path'];
            $upload['admin_id'] = $adminId;
            $upload['add_time'] = time();
            $upload['is_del'] = 0;
            $status = self::$model::base_bool('insert', $upload, 0);
            if(!$status){
                // 数据库添加失败，删除硬盘中的文件
                self::remove($data['path']);
            }
            return self::setMsg($status ? '上传成功' : '上传失败', $status, $data);
        }catch (\Exception $exception){
            return self::setMsg(encode_change($exception->getMessage(), 'utf-8'), false);
        }
    }

    /**
     * 上传文件修改
     *
     * @param array $data
     * @param int $id
     * @return bool
     */
    public static function update(array $data, int $id): bool
    {
        // TODO: Implement update() method.
        return self::setMsg('不支持修改', false);
    }

    /**
     * 上传文件删除
     *
     * @param int $id
     * @return bool
     */
    public static function delete(int $id): bool
    {
        // TODO: Implement delete() method.
        $check = self::$model::base_bool('check', [], $id); // 验证编号
        if(!$check){
            return self::setMsg('已删除', true);
        }
        // 获取文件路径
        $path = self::$model::base_string('select', $id, 'path');
        $status = self::$model::base_bool('delete', [], $id);
        if($status && strlen($path)){
            // 数据库记录删除成功 删除硬盘中的文件
            self::remove($path);
        }
        return self::setMsg($status ? '删除成功' : '删除失败', $status);
    }
}