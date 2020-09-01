<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/31
 */

namespace App\Repositories;

use App\CcForever\interfaces\RepositoryInterface;
use App\CcForever\traits\RepositoryReturnMsgData;
use App\Columns;

/**
 * 栏目
 *
 * Class ColumnsRepository
 * @package App\Repositories
 */
class ColumnsRepository implements RepositoryInterface
{
    use RepositoryReturnMsgData;

    public function __construct(Columns $model = null)
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
        self::$model = new Columns();
    }

    /**
     * 栏目列表
     * @param array $where
     * @param int $page
     * @param int $limit
     * @return bool
     */
    public static function lst(array $where, int $page, int $limit): bool
    {
        // TODO: Implement lst() method.
        $where['parent_id'] = array_key_exists('parent_id', $where) ? $where['parent_id'] : '';// 上级栏目是否存在
        $offset = page_to_offset($page, $limit); // 获取起始值
        $list = self::$model::lst($where, $offset, $limit);// 菜单列表
        return self::setMsg('栏目列表', true, $list);

    }

    /**
     * 栏目总数
     *
     * @param array $where
     * @return bool
     */
    public static function count(array $where): bool
    {
        // TODO: Implement count() method.
        $where['parent_id'] = array_key_exists('parent_id', $where) ? $where['parent_id'] : '';// 上级栏目是否存在
        $count = self::$model::count($where);
        return self::setMsg('栏目总数', true, [$count]);
    }

    /**
     * 栏目添加
     *
     * @param array $data
     * @return bool
     */
    public static function insert(array $data): bool
    {
        // TODO: Implement insert() method.
        $columns = [];
        $columns['name'] = array_key_exists('name', $data) ? $data['name'] : null;// 栏目名称
        $columns['name_alias'] = array_key_exists('name_alias', $data) && !is_null($data['name_alias']) ? $data['name_alias'] : $columns['name'];// 栏目别名
        $columns['parent_id'] = array_key_exists('parent_id', $data) ? (int)$data['parent_id'] : null;// 栏目父级
        $columns['image'] = array_key_exists('image', $data) && !is_null($data['image']) ? $data['image'] : '';// 栏目图片
        $columns['banner_image'] = array_key_exists('banner_image', $data) && !is_null($data['banner_image']) ? $data['banner_image'] : '';// 栏目轮播
        $columns['keywords'] = array_key_exists('keywords', $data) && !is_null($data['keywords']) ? $data['keywords'] : $columns['name'];// 栏目关键字
        $columns['description'] = array_key_exists('description', $data) && !is_null($data['description']) ? $data['description'] : $columns['name'];// 栏目描述
        $columns['weight'] = array_key_exists('weight', $data) && !is_null($data['weight']) ? (int)$data['weight'] : 1;// 栏目权重
        $columns['limit'] = array_key_exists('limit', $data) && !is_null($data['limit']) ? (int)$data['limit'] : 10;// 信息每页条数
        $columns['sort'] = array_key_exists('sort', $data) && !is_null($data['sort']) ? (int)$data['sort'] : 2;// 栏目排序
        $columns['navigation'] = array_key_exists('navigation', $data) && !is_null($data['navigation']) ? (int)$data['navigation'] : 1;// 栏目导航状态
        $columns['render'] = array_key_exists('render', $data) ? (int)$data['render'] : null;// 栏目渲染类型
        $columns['page'] = array_key_exists('page', $data) ? $data['page'] : null;// 栏目页面
        if(!check_null($columns['name'], $columns['parent_id'], $columns['render'], $columns['page'])){
            return self::setMsg('参数错误', false);
        }
        $columns['is_del'] = 0;
        $columns['add_time'] = time();
        $status = self::$model::base_bool('insert', $columns, 0);
        return self::setMsg($status ? '添加成功' : '添加失败', $status);
    }

    /**
     * 栏目 修改
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
        $columns = [];
        $columns['name'] = array_key_exists('name', $data) ? $data['name'] : null;// 栏目名称
        $columns['name_alias'] = array_key_exists('name_alias', $data) && !is_null($data['name_alias']) ? $data['name_alias'] : $columns['name'];// 栏目别名
        $columns['parent_id'] = array_key_exists('parent_id', $data) ? (int)$data['parent_id'] : null;// 栏目父级
        $columns['image'] = array_key_exists('image', $data) && !is_null($data['image']) ? $data['image'] : '';// 栏目图片
        $columns['banner_image'] = array_key_exists('banner_image', $data) && !is_null($data['banner_image']) ? $data['banner_image'] : '';// 栏目轮播
        $columns['keywords'] = array_key_exists('keywords', $data) && !is_null($data['keywords']) ? $data['keywords'] : $columns['name'];// 栏目关键字
        $columns['description'] = array_key_exists('description', $data) && !is_null($data['description']) ? $data['description'] : $columns['name'];// 栏目描述
        $columns['weight'] = array_key_exists('weight', $data) && !is_null($data['weight']) ? (int)$data['weight'] : 1;// 栏目权重
        $columns['limit'] = array_key_exists('limit', $data) && !is_null($data['limit']) ? (int)$data['limit'] : 10;// 信息每页条数
        $columns['sort'] = array_key_exists('sort', $data) && !is_null($data['sort']) ? (int)$data['sort'] : 2;// 栏目排序
        $columns['navigation'] = array_key_exists('navigation', $data) && !is_null($data['navigation']) ? (int)$data['navigation'] : 1;// 栏目导航状态
        $columns['render'] = array_key_exists('render', $data) ? (int)$data['render'] : null;// 栏目渲染类型
        $columns['page'] = array_key_exists('page', $data) ? $data['page'] : null;// 栏目页面
        if(!check_null($columns['name'], $columns['parent_id'], $columns['render'], $columns['page'])){
            return self::setMsg('参数错误', false);
        }
        $message = self::$model::base_array('message', $id, array_keys($columns), []);
        if($message === $columns){ // 数据库的数据和修改的数据一致
            return self::setMsg('修改成功', true);
        }
        $status = self::$model::base_bool('update', $columns, $id); // 修改数据
        return self::setMsg($status ? '修改成功' : '修改失败', $status);
    }

    /**
     * 栏目内容添加、修改、查询
     * @param array $data
     * @param bool $type
     * @return bool
     */
    public static function content(array  $data, bool $type): bool
    {
        unset($data['type']); // $type  false 添加/修改  true 查询
        $id = (int)$data['id']; // 栏目编号
        $content = $data['content']; // 栏目内容
        $markdown = array_key_exists('markdown', $data) && !is_null($data['markdown'])  ? $data['markdown'] : ''; // 栏目内容
        $returnMsg = '栏目内容'; // 返回提示
        $returnStatus = true; // 返回状态
        $returnData = []; // 返回信息
        self::$model::SetModelTable('columns_content');
        $check = self::$model::base_bool('check', [], $id);
        if($type){ // 查询
            if($check){
                $returnData = self::$model::base_array('message', $id, ['content', 'markdown'], []);
            }
            if(!count($returnData)){
                $returnData = ['content' => '', 'markdown' => ''];
            }
        }else{ // 添加/修改
            $columns = []; // 栏目内容数据
            $columns['content'] = $content; // 栏目内容
            $columns['markdown'] = $markdown; // 栏目内容
            if(!$check){ // 添加
                $columns['id'] = $id; // 栏目编号
                $columns['is_del'] = 0; // 栏目是否删除
                $returnStatus = self::$model::base_bool('insert', $columns, 0);
                $returnMsg = $returnStatus ? '添加成功' : '添加失败';
            }else{ // 修改
                $message = self::$model::base_array('message', $id, array_keys($columns), []);
                if($message === $columns){ // 数据库的数据和修改的数据一致
                    $returnMsg = '修改成功';
                }else{
                    $returnStatus = self::$model::base_bool('update', $columns, $id);
                    $returnMsg = $returnStatus ? '修改成功' : '修改失败';
                }
            }
        }
        self::$model::SetModelTable('columns');
        return self::setMsg($returnMsg, $returnStatus, $returnData);
    }

    /**
     * 栏目视图列表
     *
     * @return bool
     */
    public static function views(): bool
    {
        $viewsRepository = new ViewsRepository();
        $viewsRepositoryModel = $viewsRepository::GetModel();
        $viewsColumns = $viewsRepositoryModel::base_array('equal', ['type' => 1], ['name', 'path'], []);
        $status = (bool)count($viewsColumns);
        return self::setMsg($status ? '栏目视图列表' : '获取失败', $status, $viewsColumns);
    }

    /**
     * 栏目列表(全部)
     *
     * @return bool
     */
    public static function columns(): bool
    {
        $columns = self::$model::base_array('equal', [], ['id', 'name'], []);
        return self::setMsg('栏目视图列表', true, $columns);
    }

    /**
     * 导航
     *
     * @return array
     */
    public static function navigation(): array
    {
        $order = [];
        $order['select'] = 'weight';
        $order['value'] = 'ASC';
        $columns = self::$model::base_array('equal', ['navigation' => '1'], ['id', 'name', 'name_alias', 'parent_id', 'render', 'page'], $order);
        $formatNavigation =  self::formatNavigation($columns, 0);
        return $formatNavigation;
    }


    /**
     * 格式化导航
     *
     * @param array $columnsList
     * @param int $parentId
     * @return array
     */
    private static function formatNavigation(array $columnsList, int $parentId): array
    {
        $columnsFormatList = [];
        foreach($columnsList as &$item){
            $data = [];
            if($item['parent_id'] == $parentId){
                $data['id'] = $item['id'];
                $data['name'] = $item['name'];
                if($item['render']){
                    // 超链
                    $data['url'] = $item['page'];
                }else{
                    // 页面
                    $data['url'] = '/'.$item['page'].'/'.$item['id'].page_suffix_message();
                }
                $data['name_alias'] = $item['name_alias'];
                $data['children'] = self::formatNavigation($columnsList,$item['id']);
                $columnsFormatList[] = $data;
            }
        }
        return $columnsFormatList;
    }

    /**
     * 子栏目列表
     *
     * @param int $id
     * @param int $limit
     * @return bool
     */
    public static function children(int $id, int $limit): bool
    {
        $check = self::$model::base_bool('check', [], $id); // 验证编号
        if(!$check){ return self::setMsg('参数错误', false); }
        $order = [];
        $order['select'] = 'weight';
        $order['value'] = 'ASC';
        $columns = self::$model::base_array('equal', ['parent_id' => $id], self::$model::GetMessage(), $order);
        if($limit && count($columns) > $limit){
            return self::setMsg('栏目列表', true, array_slice($columns, 0, $limit, true));
        }
        return self::setMsg('栏目列表', (bool)count($columns), $columns);
    }

    /**
     * 栏目列表
     *
     * $ids 指定栏目编号
     *
     * @param array $ids
     * @return bool
     */
    public static function appointed(array $ids): bool
    {
        $order = [];
        $order['select'] = 'weight';
        $order['value'] = 'ASC';
        $columns = self::$model::base_array('equal_in', ['id', $ids], self::$model::GetMessage(), $order);
        return self::setMsg('栏目列表', (bool)count($columns), $columns);
    }

    /**
     * 栏目子集+
     *
     * @param int $id
     * @return array
     */
    public static function subsets(int $id): array
    {
        $check = self::$model::base_bool('check', [], $id); // 验证编号
        if(!$check){ return []; }
        $order['select'] = 'weight';
        $order['value'] = 'ASC';
        $columns = self::$model::base_array('equal', [], self::$model::GetMessage(), $order);
        $subsets = self::formatSubsets($columns, $id, []);
        return $subsets;
    }

    /**
     * 格式化栏目子集+
     *
     * @param array $columns
     * @param int $parentId
     * @param array $subsets
     * @return array
     */
    private static function formatSubsets(array $columns, int $parentId, array $subsets): array
    {
        foreach ($columns as $column){
            if($parentId == $column['parent_id']){
                $subsets[] = $column;
                self::formatSubsets($columns, $column['id'], $subsets);
            }
        }
        return $subsets;
    }

    /**
     * 栏目编号(渲染类型为页面)
     *
     * @return array
     */
    public static function pageColumnsIds(): array
    {
        $order = [];
        $order['select'] = 'weight';
        $order['value'] = 'ASC';
        return self::$model::base_array('pluck', ['render', [0]], ['id'], $order);
    }

    /**
     * 顶级栏目编号
     *
     * @param int $id
     * @return int
     */
    public static function topColumnId(int $id): int
    {
        $check = self::$model::base_bool('check', [], $id); // 验证编号
        if(!$check){ return $id; }
        $order['select'] = 'weight';
        $order['value'] = 'ASC';
        $columns = self::$model::base_array('equal', [], ['id', 'parent_id'], $order);
        return self::formatTopColumnId($columns, $id);
    }

    /**
     * 格式化顶级栏目编号
     *
     * @param array $columns
     * @param int $parentId
     * @return int
     */
    public static function formatTopColumnId(array $columns, int $parentId): int
    {
        foreach ($columns as &$column){
            if($column['id'] === $parentId){
                if(!$column['parent_id']) { return $parentId;}
                return self::formatTopColumnId($columns, $column['parent_id']);
            }
        }
    }
}