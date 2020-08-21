<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/21
 */
namespace App\Http\Controllers\upload;

use App\CcForever\controller\BaseController;
use App\CcForever\extend\JsonExtend;
use App\Http\Requests\Upload\UploadsRequest;
use App\Repositories\UploadsRepository;

/**
 * 上传控制器
 *
 * Class UploadsController
 * @package App\Http\Controllers\upload
 */
class UploadsController extends BaseController
{
    /**
     * 单文件上传
     *
     * @param UploadsRequest $uploadsRequest
     * @param UploadsRepository $uploadsRepository
     * @return object
     */
    public function upload(UploadsRequest $uploadsRequest, UploadsRepository $uploadsRepository): object
    {
        $file = $uploadsRequest->all();
        $adminId = auth('login')->id();
        if ($uploadsRequest->hasFile($file['name']) && $uploadsRequest->file($file['name'])->isValid()) {
            try{
                $bool = $uploadsRepository::insert(['admin_id' => $adminId, 'file' => $uploadsRequest->file($file['name']), 'path' => $file['path']]);
                if($bool){
                    return JsonExtend::success($uploadsRepository::returnMsg('上传文件失败'), $uploadsRepository::returnData([]));
                }
                return JsonExtend::error($uploadsRepository::returnMsg('上传文件失败'));
            }catch (\Exception $e){
                return JsonExtend::error(encode_change($e->getMessage(), 'utf-8'));
            }
        }
        return JsonExtend::error('请选择上传文件');
    }
}