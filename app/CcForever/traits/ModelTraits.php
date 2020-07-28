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
     * bool返回值的操作
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
     * @param array
     * $data
     * @param int $id
     * @param string $field
     * @return bool
     */
    private static function model_handle_update(array $data, int $id, string $field): bool
    {
        try{
            $update = DB::table(self::$modelTable)->where($field, $id)->update($data);
            return (bool)$update;
        }catch (\Exception $exception){
            return false;
        }
    }

    /**
     * 删除
     * @param string $id
     * @param string $field
     * @return bool
     */
    private static function model_handle_delete(string $id, string $field): bool
    {
        $update = DB::table(self::$modelTable)->where($field, $id)->update(['is_del' => 1]);
        return (bool)$update;
    }

    /**
     * 验证编号是否存在 false 不存在  true 存在
     * @param int $id
     * @param string $field
     * @return bool
     */
    private static function model_handle_check(int $id, string $field): bool
    {
        $count = DB::table(self::$modelTable)->where($field, $id)->where('is_del', 0)->count();
        return (bool)$count;
    }

    /**
     * string返回值操作
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
     * @param int $id
     * @param string $select
     * @return string
     */
    private static function model_handle_select(int $id, string $select): string
    {
        $value = DB::table(self::$modelTable)->where('id', $id)->where('is_del', 0)->value($select);
        return is_null($value) ? '' : $value;
    }

    /**
     * array返回值操作
     * @param string $function
     * @param mixed ...$parameter
     * @return array
     */
    public static function base_array(string $function, ...$parameter): array
    {
        $array = [];
        try{
            list($data, $id, $select) = $parameter;
            switch ($function){
                case 'message': // 信息
                    $array = self::model_handle_message($id, $select);
                    break;
                // ...
                default:;
            }
        }catch (\Exception $exception){}
        return $array;
    }

    /**
     * 信息
     * @param int $id
     * @param array $select
     * @return array
     */
    public static function model_handle_message(int $id, array $select): array
    {
        // TODO: Implement message() method.
        $message = DB::table(self::$modelTable)->where('id', $id)->select($select)->where('is_del', 0)->first();
        return (array)$message;
    }
}