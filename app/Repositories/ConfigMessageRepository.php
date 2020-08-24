<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/4
 */
namespace App\Repositories;

use App\CcForever\interfaces\RepositoryInterface;
use App\CcForever\traits\RepositoryReturnMsgData;
use App\ConfigMessage;

/**
 * 配置信息
 *
 * Class ConfigMessageRepository
 * @package App\Repositories
 */
class ConfigMessageRepository implements RepositoryInterface
{
    use RepositoryReturnMsgData;

    public function __construct(ConfigMessage $model = null)
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
        self::$model = new ConfigMessage();
    }

    /**
     * 配置信息列表
     *
     * @param array $where
     * @param int $page
     * @param int $limit
     * @return bool
     */
    public static function lst(array $where, int $page, int $limit): bool
    {
        // TODO: Implement lst() method.
        $where['category_id'] = array_key_exists('category_id', $where) && !is_null($where['category_id']) ? (int)$where['category_id'] : null;
        if(is_null($where['category_id'])){
            return self::setMsg('参数错误', false);
        }
        $offset = page_to_offset($page, $limit); // 获取起始值
        $list = self::$model::lst($where, $offset, $limit);// 配置分类列表
        return self::setMsg('配置信息列表', true, $list);
    }

    /**
     * 配置信息总数
     *
     * @param array $where
     * @return bool
     */
    public static function count(array $where): bool
    {
        // TODO: Implement count() method.
        $where['category_id'] = array_key_exists('category_id', $where) && !is_null($where['category_id']) ? (int)$where['category_id'] : null;
        if(is_null($where['category_id'])){
            return self::setMsg('参数错误', false);
        }
        $count = self::$model::count($where);//配置信息总数
        return self::setMsg('配置信息总数', true, [$count]);
    }

    /**
     * 配置信息添加
     *
     * @param array $data
     * @return bool
     */
    public static function insert(array $data): bool
    {
        // TODO: Implement insert() method.
        $configMessage = [];
        $configMessage['name'] = array_key_exists('name', $data) ? $data['name'] : null;// 配置信息名称
        $configMessage['description'] = array_key_exists('description', $data) ? $data['description'] : $configMessage['name'];// 配置信息描述
        $configMessage['select'] = array_key_exists('select', $data) ? $data['select'] : null;// 配置信息唯一值
        $configMessage['category_id'] = array_key_exists('category_id', $data) ? (int)$data['category_id'] : null;// 配置类型编号
        $configMessage['type'] = array_key_exists('type', $data) ? (int)$data['type'] : null;// 配置信息类型
        $configMessage['type_value'] = array_key_exists('type_value', $data) && !is_null($data['type_value']) ? $data['type_value'] : '';// 配置信息类型
        $configMessage['value'] = array_key_exists('value', $data) && !is_null($data['value']) ? $data['value'] : '';// 配置信息类型
        // 配置信息名称、配置信息唯一值、配置类型编号、配置信息类型
        if(!check_null($configMessage['name'], $configMessage['select'], $configMessage['category_id'], $configMessage['type'])){
            return self::setMsg('参数错误', false);
        }
        // 静态配置名称
        $staticConfigName = self::$model::GetStaticConfigName();
        // 验证select唯一值(静态配置)
        if(in_array($configMessage['select'], $staticConfigName)){
            return self::setMsg('唯一值已存在', false);
        }
        // 验证select唯一值(数据库)
        $equal = self::$model::base_array('equal', ['select' => $configMessage['select']], ['select'], []);
        if(count($equal)){
            return self::setMsg('唯一值已存在', false);
        }
        // 验证配置分类编号
        $configCategoryRepository = new ConfigCategoryRepository();
        $configCategoryRepositoryModel = $configCategoryRepository::GetModel();
        $configCategoryIdCheck = $configCategoryRepositoryModel::base_bool('check', [], $configMessage['category_id']); // 验证配置分类编号
        if(!$configCategoryIdCheck){
            return self::setMsg('配置分类不存在', false);
        }
        // 验证类型为 2 单选 3 多选的type_value和value不能为空并且value是type_value中的数据
        switch ($configMessage['type']){
            case 2:
            case 3:
                if(!strlen($configMessage['type_value'])){ // 验证配置信息类型的值是否存在
                    return self::setMsg('请填写配置信息类型的值', false);
                }
                // 验证配置信息类型的值是否格式正确
                $typeValue = format_config_message_type_value($configMessage['type_value']);
                if(!count($typeValue)){
                    return self::setMsg('配置信息类型的值格式错误，请按照field:value|field:value...', false);
                }
                if(!strlen($configMessage['value'])){ // 验证配置信息值为空时
                    return self::setMsg('请填写配置信息默认值', false);
                }
                // 验证配置信息默认值
                $configMessageValueCheck = true;
                foreach ($typeValue as $key=>$values){
                    list($field) = $values;
                    if($field == $configMessage['value']){ // 配置信息默认值存在
                        $configMessageValueCheck = false;
                        break;
                    }
                }
                if($configMessageValueCheck){ // 配置信息默认值不存在
                    return self::setMsg('配置信息默认值错误，请重新填写', false);
                }
                break;
            default:;
        }
        $configMessage['is_del'] = 0;
        $configMessage['add_time'] = time();
        $status = self::$model::base_bool('insert', $configMessage, 0);
        return self::setMsg($status ? '添加成功' : '添加失败', $status);
    }

    /**
     * 配置信息修改
     *
     * @param array $data
     * @param int $id
     * @return bool
     */
    public static function update(array $data, int $id): bool
    {
        // TODO: Implement update() method.
        $check = self::$model::base_bool('check', [], $id); // 验证编号
        if(!$check){
            return self::setMsg('参数错误', false);
        }
        $configMessage = [];
        $configMessage['name'] = array_key_exists('name', $data) ? $data['name'] : null;// 配置信息名称
        $configMessage['description'] = array_key_exists('description', $data) ? $data['description'] : $configMessage['name'];// 配置信息描述
        $configMessage['value'] = array_key_exists('value', $data) && !is_null($data['value']) ? $data['value'] : '';// 配置信息类型
        // 配置信息名称、配置信息唯一值、配置类型编号、配置信息类型
        if(!check_null($configMessage['name'])){
            return self::setMsg('参数错误', false);
        }
        // 获取配置信息信息
        $message = self::$model::base_array('message', $id, self::$model::GetMessage(), []);
        // 验证类型为 2 单选 3 多选 的 value不能为空并且value是type_value中的数据
        switch ($message['type']){
            case 2:
            case 3:
                // 验证配置信息类型的值是否格式正确
                $typeValue = format_config_message_type_value($message['type_value']);
                if(!count($typeValue)){
                    return self::setMsg($message['name'].'  配置信息禁止修改', false);
                }
                if(!strlen($configMessage['value'])){ // 验证配置信息值为空时
                    return self::setMsg('请填写'.$configMessage['name'].'的值', false);
                }
                // 验证配置信息值
                $configMessageValueCheck = true;
                foreach ($typeValue as $key=>$values){
                    list($field) = $values;
                    if($field == $configMessage['value']){ // 配置信息值存在
                        $configMessageValueCheck = false;
                        break;
                    }
                }
                if($configMessageValueCheck){ // 配置信息值不存在
                    return self::setMsg($configMessage['name'].'的值错误，请重新填写', false);
                }
                break;
            default:;
        }
        $message = self::$model::base_array('message', $id, array_keys($configMessage), []);
        if($message === $configMessage){ // 数据库的数据和修改的数据一致
            return self::setMsg('修改成功', true);
        }
        $status = self::$model::base_bool('update', $configMessage, $id); // 修改数据
        return self::setMsg($status ? '修改成功' : '修改失败', $status);
    }

    /**
     * 获取配置信息
     *
     * @param string $select
     * @return bool
     */
    public static function config(string $select): bool
    {
        // 不可见配置信息
        $notViewableSelect = self::$model::GetNotViewableSelect();
        // 验证是否在不可见配置信息字段中
        if(in_array($select, $notViewableSelect)){
            return self::setMsg(power_message(), false);
        }
        // 静态配置名称
        $staticConfigName = self::$model::GetStaticConfigName();
        // 验证是否获取静态配置
        if(in_array($select, $staticConfigName)){
            // 获取静态配置
            $value = self::$model::GetStaticConfigValue($select);
        }else{
            // 获取数据库配置信息
            $value = self::$model::base_string('select', ['select', $select], 'value');
        }
        return self::setMsg($select.'配置信息', true, [$value]);
    }
}