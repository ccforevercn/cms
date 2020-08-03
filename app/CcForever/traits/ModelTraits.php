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
     * @param bool $alias
     * @return string
     */
    public static function GetAlias(bool $alias = false): string
    {
        return $alias ? self::$modelTable : self::$modelTable.'.';
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
            list($data, $id) = $parameter;
            $field  = 'id';
            if(is_array($id)){
                list($id, $field) = $id;
            }
            switch ($function){
                case 'insert': // 插入
                    $bool = self::model_handle_insert($data);
                    break;
                case 'update': // 修改
                    $bool = self::model_handle_update($data, $id, $field);
                    break;
                case 'delete': // 删除
                    $bool = self::model_handle_delete($id, $field);
                    break;
                case 'check': // 验证编号
                    $bool = self::model_handle_check($id, $field);
                    break;
                    // ...
                default:;
            }
        }catch (\Exception $exception){}
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
        try{
            return (bool)DB::table(self::$modelTable)->insert($data);
        }catch (\Exception $exception){
            return false;
        }
    }

    /**
     * 修改
     *
     * @param array $data
     * @param int $value
     * @param string $field
     * @return bool
     */
    private static function model_handle_update(array $data, int $value, string $field): bool
    {
        try{
            $update = DB::table(self::$modelTable)->where($field, $value)->update($data);
            return (bool)$update;
        }catch (\Exception $exception){
            return false;
        }
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
        $update = DB::table(self::$modelTable)->where($field, $value)->update(['is_del' => 1]);
        return (bool)$update;
    }

    /**
     * 验证编号是否存在 false 不存在  true 存在
     *
     * @param int $value
     * @param string $field
     * @return bool
     */
    private static function model_handle_check(int $value, string $field): bool
    {
        $count = DB::table(self::$modelTable)->where($field, $value)->where('is_del', 0)->count();
        return (bool)$count;
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
            list($data, $id, $select) = $parameter;
            switch ($function){
                case 'select': // 查询字段
                    $string = self::model_handle_select($id, $select);
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
     * @param int $value
     * @param string $select
     * @return string
     */
    private static function model_handle_select(int $value, string $select): string
    {
        $value = DB::table(self::$modelTable)->where('id', $value)->where('is_del', 0)->value($select);
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
            switch ($function){
                case 'message': // 信息
                    $array = self::model_handle_message($where, $select);
                    break;
                case 'pluck': // 批量获取一列值
                    $array = self::model_handle_pluck($where, $select, $order);
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
        $message = DB::table(self::$modelTable)->where('id', $value)->select($select)->where('is_del', 0)->first();
        return (array)$message;
    }

    /**
     * 列值
     *
     * @param array $values
     * @param array $select
     * @param array $order
     * @return array
     */
    public static function model_handle_pluck(array $values, array $select, array $order): array
    {
        if(count($select) === 1){
            $message = DB::table(self::$modelTable)->whereIn('id', $values)->where('is_del', 0)->pluck($select[0])->orderBy($order['select'], $order['value'])->toArray();
        }else{
            $message = DB::table(self::$modelTable)->whereIn('id', $values)->where('is_del', 0)->select($select)->orderBy($order['select'], $order['value'])->get();
            $message = is_null($message) ? [] : $message->toArray();
            foreach ($message as $key=>$value){
                $message[$key] = (array)$value;
            }
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