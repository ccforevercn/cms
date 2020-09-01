<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/20
 */

namespace App\CcForever\traits;

use Illuminate\Support\Facades\DB;

trait ModelTraits
{
    /**
     * 表别名
     *
     * @param bool $alias false 表名. true 表名
     * @param bool $prefix false 不加前缀 true 加前缀
     * @return string
     */
    public static function GetAlias(bool $alias = false, bool $prefix = false): string
    {
        $prefix = $prefix ? config('database.db_prefix') : '';
        return $alias ? $prefix.self::$modelTable : $prefix.self::$modelTable.'.';
    }

    /**
     * 设置表名称
     *
     * @param string $modelTable
     */
    public static function SetModelTable(string $modelTable):void
    {
        self::$modelTable = $modelTable;
    }
    /**
     * 所有字段
     *
     * @return array
     */
    public static function GetSelect(): array
    {
        return self::$select;
    }

    /**
     * 基本信息
     *
     * @return array
     */
    public static function GetMessage(): array
    {
        return self::$message;
    }

    /**
     * bool返回值的操作
     *
     * @param string $function
     * @param mixed ...$parameter
     * @return bool
     */
    public static function  base_bool(string $function, ...$parameter): bool
    {
        $bool = false;
        try{
            list($data, $value) = $parameter;
            $field  = 'id';
            if(is_array($value)){
                list($value, $field) = $value;
            }
            switch ($function){
                case 'insert': // 插入
                    $bool = self::model_handle_insert($data);
                    break;
                case 'update': // 修改
                    $bool = self::model_handle_update($data, $value, $field);
                    break;
                case 'updates': // 批量修改
                    $bool = self::model_handle_updates($data, $value, $field);
                    break;
                case 'delete': // 删除
                    $bool = self::model_handle_delete($value, $field);
                    break;
                case 'check': // 验证编号
                    $bool = self::model_handle_check($value, $field);
                    break;
                    // ...
                default:;
            }
        }catch (\Exception $exception){ dd(encode_change($exception->getMessage(), 'utf-8')); }
        return $bool;
    }

    /**
     * 添加
     *
     * @param array $data
     * @return bool
     */
    private static function model_handle_insert(array $data): bool
    {
        return (bool)DB::table(self::$modelTable)->insert($data);
    }

    /**
     * 修改
     *
     * @param array $data
     * @param string $value
     * @param string $field
     * @return bool
     */
    private static function model_handle_update(array $data, string $value, string $field): bool
    {
        return (bool)DB::table(self::$modelTable)->where($field, $value)->update($data);
    }

    /**
     * 批量修改
     *
     * @param array $data
     * @param string $value
     * @param string $field
     * @return bool
     */
    private static function model_handle_updates(array $data, string $value, string $field): bool
    {
        return (bool)DB::table(self::$modelTable)->whereIn($field, explode(',', $value))->update($data);
    }

    /**
     * 删除
     *
     * @param string $value
     * @param string $field
     * @return bool
     */
    private static function model_handle_delete(string $value, string $field): bool
    {
        return (bool)DB::table(self::$modelTable)->where($field, $value)->update(['is_del' => 1]);
    }

    /**
     * 验证编号是否存在 false 不存在  true 存在
     *
     * @param string $value
     * @param string $field
     * @return bool
     */
    private static function model_handle_check(string $value, string $field): bool
    {
        return (bool)DB::table(self::$modelTable)->where($field, $value)->where('is_del', 0)->count();
    }

    /**
     * string返回值操作
     *
     * @param string $function
     * @param mixed ...$parameter
     * @return string
     */
    public static function base_string(string $function, ...$parameter): string
    {
        $string = '';
        try{
            list($value, $select) = $parameter;
            $field = 'id';
            if(is_array($value)){
                list($field, $value) = $value;
            }
            switch ($function){
                case 'select': // 查询字段
                    $string = self::model_handle_select($field, $value, $select);
                    break;
                // ...
                default:;
            }
        }catch (\Exception $exception){}
        return $string;
    }

    /**
     * 查询字段值
     *
     * @param string $field
     * @param string $value
     * @param string $select
     * @return string
     */
    private static function model_handle_select(string $field, string $value, string $select): string
    {
        $value = DB::table(self::$modelTable)->where($field, $value)->where('is_del', 0)->value($select);
        return is_null($value) ? '' : $value;
    }

    /**
     * array返回值操作
     *
     * @param string $function
     * @param mixed ...$parameter
     * @return array
     */
    public static function base_array(string $function, ...$parameter): array
    {
        $array = [];
        try{
            list($where, $select, $order) = $parameter;
            // 排序为空时，默认编号升序
            if(!count($order)){$order = ['select' => 'id', 'value' => 'DESC'];}
            switch ($function){
                case 'message': // 信息
                    $array = self::model_handle_message($where, $select);
                    break;
                case 'pluck': // 批量获取一列值
                    list($field, $value) = $where;
                    $array = self::model_handle_pluck($field, $value, $select, $order);
                    break;
                case 'equal':// 获取where相同的值
                    $array = self::model_handle_equal($where, $select, $order);
                    break;
                case 'equal_in':// 获取where相同的值
                    list($field, $value) = $where;
                    $array = self::model_handle_equal_in($field, $value, $select, $order);
                    break;
                case 'all': // 批量获取指定字段值
                    $array = self::model_handle_all($select, $order);
                    break;
                // ...
                default:;
            }
        }catch (\Exception $exception){}
        return $array;
    }

    /**
     * 信息
     *
     * @param int $value
     * @param array $select
     * @return array
     */
    public static function model_handle_message(int $value, array $select): array
    {
        // TODO: Implement message() method.
        return (array)DB::table(self::$modelTable)->where('id', $value)->select($select)->where('is_del', 0)->first();
    }

    /**
     * 列值
     *
     * @param string $field
     * @param array $values
     * @param array $select
     * @param array $order
     * @return array
     */
    public static function model_handle_pluck(string $field, array $values, array $select, array $order): array
    {
        if(count($select) === 1){
            $message = DB::table(self::$modelTable)->whereIn($field, $values)->where('is_del', 0)->pluck($select[0])->toArray();
        }else{
            $message = DB::table(self::$modelTable)->whereIn($field, $values)->where('is_del', 0)->select($select)->orderBy($order['select'], $order['value'])->get();
            $message = is_null($message) ? [] : $message->toArray();
            foreach ($message as $key=>$value){
                $message[$key] = (array)$value;
            }
        }
        return $message;
    }

    /**
     * 相同值(单个)
     *
     * @param array $where
     * @param array $select
     * @param array $order
     * @return array
     */
    public static function model_handle_equal(array $where, array $select, array $order):array
    {
        $message = DB::table(self::$modelTable)->where($where)->where('is_del', 0)->select($select)->orderBy($order['select'], $order['value'])->get();
        $message = is_null($message) ? [] : $message->toArray();
        foreach ($message as $key=>$value){
            $message[$key] = (array)$value;
        }
        return $message;
    }

    /**
     * 相同值(多个)
     *
     * @param string $field
     * @param array $value
     * @param array $select
     * @param array $order
     * @return array
     */
    public static function model_handle_equal_in(string $field, array $value, array $select, array $order):array
    {
        $message = DB::table(self::$modelTable)->whereIn($field, $value)->where('is_del', 0)->select($select)->orderBy($order['select'], $order['value'])->get();
        $message = is_null($message) ? [] : $message->toArray();
        foreach ($message as $key=>$value){
            $message[$key] = (array)$value;
        }
        return $message;
    }


    /**
     * 批量获取指定字段值
     *
     * @param array $select
     * @param array $order
     * @return array
     */
    public static function model_handle_all(array $select, array $order): array
    {
        $message = DB::table(self::$modelTable)->where('is_del', 0)->select($select)->orderBy($order['select'], $order['value'])->get();
        $message = is_null($message) ? [] : $message->toArray();
        foreach ($message as $key=>$value){
            $message[$key] = (array)$value;
        }
        return $message;
    }
}