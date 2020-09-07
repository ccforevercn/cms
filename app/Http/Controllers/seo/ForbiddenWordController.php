<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/9/7
 */
namespace App\Http\Controllers\seo;

use App\CcForever\controller\BaseController;
use App\CcForever\extend\ForbiddenWordExtend;
use App\CcForever\extend\JsonExtend;

/**
 * 违禁词控制器
 *
 * Class ForbiddenWordController
 * @package App\Http\Controllers\seo
 */
class ForbiddenWordController extends BaseController
{
    /**
     * 获取违禁词
     *
     * @return object
     */
    public function forbidden(): object
    {
        $content = ForbiddenWordExtend::GetForbiddenWord();
        return JsonExtend::success('违禁词内容', ['content'=> $content]);
    }

    /**
     * 修改违禁词
     *
     * @return object
     */
    public function update(): object
    {
        // 违禁词
        $content = app('request')->input('content', '');
        if(is_null($content)){
            return JsonExtend::error('修改失败');
        }
        $bool = ForbiddenWordExtend::update($content);
        if($bool){
            return JsonExtend::success('修改成功');
        }
        return JsonExtend::error('修改失败');
    }

    /**
     * 验证违禁词
     *
     * @return object
     */
    public function check(): object
    {
        $forbiddenWord = ForbiddenWordExtend::check();
        return JsonExtend::success('违禁词列表', $forbiddenWord);
    }
}
