<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/3
 */

namespace App\Http\Requests\Messages;

use App\Http\Requests\Request;

/**
 * 信息添加验证
 *
 * Class MessagesInsertRequest
 * @package App\Http\Requests\Messages
 */
class MessagesInsertRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' =>  'bail|required|max:20',
            'columns_id' => 'bail|required|integer|min:1',
            'tags_id' => 'bail|present',
            'image' => 'bail|nullable|max:128',
            'writer' => 'bail|nullable|max:32',
            'click' =>  'bail|nullable|integer|min:0|max:1000',
            'weight' =>  'bail|nullable|integer|min:0|max:99999',
            'keywords' =>  'bail|nullable|max:80',
            'description' =>  'bail|nullable|max:150',
            'index' =>  'bail|nullable|integer|min:0|max:1',
            'hot' =>  'bail|nullable|integer|min:0|max:1',
            'release' =>  'bail|nullable|integer|min:0|max:1',
            'update_time' => 'bail|nullable|integer|max:2147483647',
            'release_time' => 'bail|nullable|integer|max:2147483647',
            'page' =>  'bail|required|max:32',
        ];
    }

    /**
     * 重写参数描述
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => '请填写文章名称',
            'name.max' => '文章名称不能超过20个汉字',
            'columns_id.required' => '请选择栏目',
            'columns_id.min' => '栏目不存在',
            'tags_id.present' => '参数错误',
//            'image.required' => '请选择栏目图片',
            'image.max' => '栏目图片不能超过128位',
//            'writer.required' => '请填写文章作者',
            'writer.max' => '文章作者不能超过32个字符',
//            'click.required' => '请填写点击量',
            'click.integer' => '点击量类型错误',
            'click.min' => '点击量不能小于0',
            'click.max' => '点击量不能大于1000',
//            'weight.required' => '请填写权重',
            'weight.integer' => '权重类型错误',
            'weight.min' => '权重不能小于0',
            'weight.max' => '权重不能大于99999',
//            'keywords.required' => '请填写栏目关键字',
            'keywords.max' => '栏目关键字不能超过80个汉字',
//            'description.required' => '请填写栏目描述',
            'description.max' => '栏目描述不能超过150个汉字',
//            'index.required' => '请选择首页推荐状态',
            'index.integer' => '首页推荐状态类型错误',
            'index.min' => '首页推荐状态错误，请重新选择',
            'index.max' => '首页推荐状态错误，请重新选择',
//            'hot.required' => '请选择热门推荐状态',
            'hot.integer' => '热门推荐状态类型错误',
            'hot.min' => '热门推荐状态错误，请重新选择',
            'hot.max' => '热门推荐状态错误，请重新选择',
//            'release.required' => '请选择文章发布状态',
            'release.integer' => '文章发布状态类型错误',
            'release.min' => '文章发布状态错误，请重新选择',
            'release.max' => '文章发布状态错误，请重新选择',
//            'update_time.required' => '请选择文章修改时间',
            'update_time.integer' => '文章修改时间参数类型错误',
            'update_time.max' => '文章修改时间错误，请重新选择',
//            'release_time.required' => '请选择文章发布时间',
            'release_time.integer' => '文章发布时间参数类型错误',
            'release_time.max' => '文章发布时间错误，请重新选择',
            'page.required' => '请选择栏目页面/链接',
            'page.max' => '栏目页面/链接不能超过32个字符',
        ];
    }
}
