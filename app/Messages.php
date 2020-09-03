<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/3
 */

namespace App;

use App\CcForever\interfaces\ModelInterface;
use App\CcForever\model\BaseModel;
use App\CcForever\traits\ModelTraits;
use Illuminate\Support\Facades\DB;

class Messages extends BaseModel implements ModelInterface
{
    use ModelTraits;

    protected $primaryKey = 'id'; // 主键

    protected $table = 'messages'; // 表名

    /**
     * 表名 ModelTraits 使用
     *
     * @var string
     */
    protected static $modelTable = 'messages';

    /**
     * 表所有字段
     *
     * @var array
     */
    private static $select = ['id', 'name', 'columns_id', 'image', 'writer', 'click', 'weight', 'keywords', 'description', 'index', 'hot', 'release', 'add_time', 'update_time', 'release_time', 'page', 'is_del'];

    /**
     * 基本信息
     *
     * @var array
     */
    private static $message = ['id', 'name', 'columns_id', 'image', 'writer', 'click', 'weight', 'keywords', 'description', 'index', 'hot', 'release', 'add_time', 'update_time', 'release_time', 'page', ];

    /**
     * 状态类型
     *
     * @var array
     */
    private static $state = ['index', 'hot', 'release'];

    /**
     * 编号查询 唯一索引
     *
     * @param $query
     * @param int $id
     * @return mixed
     */
    public static function scopeId($query, int $id)
    {
        return $query->where(self::GetAlias().'id', $id);
    }

    /**
     * 栏目编号 普通索引
     *
     * @param $query
     * @param int $columnsId
     * @return mixed
     */
    public static function scopeColumnsId($query, int $columnsId)
    {
        return $query->where(self::GetAlias().'columns_id', $columnsId);
    }

    /**
     * 首页推荐 普通索引
     *
     * @param $query
     * @param int $index
     * @return mixed
     */
    public static function scopeIndex($query, int $index)
    {
        return $query->where(self::GetAlias().'index', $index);
    }

    /**
     * 默认推荐 普通索引
     *
     * @param $query
     * @param int $hot
     * @return mixed
     */
    public static function scopeHot($query, int $hot)
    {
        return $query->where(self::GetAlias().'hot', $hot);
    }

    /**
     * 发布状态 普通索引
     *
     * @param $query
     * @param int $release
     * @return mixed
     */
    public static function scopeRelease($query, int $release)
    {
        return $query->where(self::GetAlias().'release', $release);
    }

    /**
     * 是否删除 普通索引
     *
     * @param $query
     * @param int $isDel
     * @return mixed
     */
    public static function scopeIsDel($query, int $isDel)
    {
        return $query->where(self::GetAlias().'is_del', $isDel);
    }

    /**
     * 权重排序 普通索引
     *
     * @param $query
     * @param int $weight
     * @return mixed
     */
    public static function scopeWeight($query, int $weight)
    {
        return $query->where(self::GetAlias().'weight', $weight);
    }

    /**
     * 修改时间
     *
     * @param $query
     * @param int $updateTime
     * @return mixed
     */
    public static function scopeUpdateTime($query, int $updateTime)
    {
        return $query->where(self::GetAlias().'update_time', $updateTime);
    }

    /**
     * 查询条件
     *
     * @param $query
     * @param array $where
     * @return mixed
     */
    public static function scopeListWhere($query, array $where)
    {
        $query = strlen($where['columns_id']) ? self::columnsId($where['columns_id']) : $query; // 栏目编号
        $query = strlen($where['index']) ? self::index($where['index']) : $query; // 首页推荐
        $query = strlen($where['hot']) ? self::hot($where['hot']) : $query; // 热门推荐
        $query = strlen($where['release']) ? self::release($where['release']) : $query; // 发布状态
        return $query;
    }

    /**
     * 信息列表
     *
     * @param array $where
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public static function lst(array $where, int $offset, int $limit): array
    {
        // TODO: Implement lst() method.
        $model = new self;
        $model = $model->listWhere($where);
        $model = $model->isDel(0);
        $model = $model->select(self::GetMessage());
        $model = $model->offset($offset);
        $model = $model->limit($limit);
        $list = $model->get();
        $list = is_null($list) ? [] : $list->toArray();
        return $list;
    }

    /**
     * 信息总数
     *
     * @param array $where
     * @return int
     */
    public static function count(array $where): int
    {
        // TODO: Implement count() method.
        return self::listWhere($where)->isDel(0)->count();
    }

    /**
     * 信息 点击量
     *
     * @param int $id
     * @param int $click
     * @return bool
     */
    public static function click(int $id, int $click): bool
    {
        $result = (bool)self::id($id)->increment('click', $click);
        return $result;
    }

    /**
     * 状态类型
     *
     * @return array
     */
    public static function GetState(): array
    {
        return self::$state;
    }

    /**
     * 信息标签
     *
     * @param string $unique
     * @return array
     */
    public static function tags(string $unique): array
    {
        $tags = DB::table('messages_tags')->where('unique', $unique)->leftJoin(Tags::GetAlias(true), 'messages_tags.tag_id', '=', Tags::GetAlias().'id')->where(Tags::GetAlias().'status', 1)->where(Tags::GetAlias().'is_del', 0)->select(Tags::GetAlias().'id as tid', Tags::GetAlias().'name as tname')->orderBy(Tags::GetAlias().'id', 'DESC')->get();
        $tags = is_null($tags) ? [] : $tags->toArray();
        foreach ($tags as $key=>$tag){
            $tags[$key] = (array)$tag;
        }
        return $tags;
    }

    /**
     * 信息列表
     *
     * @param array $columnIds
     * @param array $order
     * @param int $offset
     * @param int $limit
     * @param int $type
     * @return array
     */
    public static function messages(array $columnIds, array $order, int $offset, int $limit, int $type): array
    {
        $select[] = Columns::GetAlias().'name as cname';
        $select[] = Columns::GetAlias().'name_alias as cname_alias';
        $select[] = Columns::GetAlias().'id as cid';
        $select[] = self::GetAlias().'name';
        $select[] = self::GetAlias().'id';
        $select[] = self::GetAlias().'image';
        $select[] = self::GetAlias().'writer';
        $select[] = self::GetAlias().'click';
        $select[] = self::GetAlias().'keywords';
        $select[] = self::GetAlias().'unique';
        $select[] = self::GetAlias().'description';
        $select[] = self::GetAlias().'update_time';
        $select[] = self::GetAlias().'page';
        $model = new self;
        $model = $model->select($select);
        // 栏目表
        $model = $model->leftJoin(Columns::GetAlias(true), self::GetAlias().'columns_id', '=', Columns::GetAlias().'id');
        $model = $model->where(self::GetAlias().'is_del', 0);
        $model = $model->whereIn(self::GetAlias().'columns_id', $columnIds);
        $model = $model->where(self::GetAlias().'release', 1);
        $model = $model->when(self::hasTableIndex(self::GetAlias(true, true).'_columns_id_index'),function ($query){
            $query->from(DB::raw('`'. self::GetAlias(true, true) .'` FORCE INDEX (`cc_messages_columns_id_index`)'));
        });
        switch ($type){
            case 1:
                $model = $model->where(self::GetAlias().'index', 1);
                break;
            case 2:
                $model = $model->where(self::GetAlias().'hot', 1);
                break;
            default:;
        }
        $model = $model->offset($offset);
        $model = $model->limit($limit);
        $model = $model->orderBy(self::GetAlias().$order['select'], $order['value']);
        return $model->get()->each(function ($item){
            $tags = array_map(function ($tag){
                return $tag['tname'];
            }, self::tags($item->unique));
            $item['tag'] = implode(',', $tags);
        })->toArray();
    }

    /**
     * 信息列表 总数
     *
     * @param array $columnIds
     * @param int $type
     * @return int
     */
    public static function messagesCount(array $columnIds, int $type): int
    {
        $model = new self;
        $model = $model->where(self::GetAlias().'is_del', 0);
        $model = $model->whereIn(self::GetAlias().'columns_id', $columnIds);
        $model = $model->where(self::GetAlias().'release', 1);
        $model = $model->when(self::hasTableIndex(self::GetAlias(true, true).'_columns_id_index'),function ($query){
            $query->from(DB::raw('`'. self::GetAlias(true, true) .'` FORCE INDEX (`cc_messages_columns_id_index`)'));
        });
        switch ($type){
            case 1:
                $model = $model->where(self::GetAlias().'index', 1);
                break;
            case 2:
                $model = $model->where(self::GetAlias().'hot', 1);
                break;
            default:;
        }
        return $model->count();
    }

    /**
     * 信息数据(当前栏目下信息所有数据)
     *
     * @param int $columnId
     * @return array
     */
    public static function messageTotal(int $columnId): array
    {
        $select[] = DB::raw('(select '. Columns::GetAlias(false, true).'name from '.Columns::GetAlias(true, true).' where '.Columns::GetAlias(false, true).'id = '.self::GetAlias(false, true).'columns_id)  as cname');
        $select[] = DB::raw('(select '.Columns::GetAlias(false, true).'name_alias from '.Columns::GetAlias(true, true).' where '.Columns::GetAlias(false, true).'id = '.self::GetAlias(false, true).'columns_id)  as cname_alias');
        $select[] = DB::raw('(select '.Columns::GetAlias(false, true).'id from '.Columns::GetAlias(true, true).' where '.Columns::GetAlias(false, true).'id = '.self::GetAlias(false, true).'columns_id) as cid');
        $alias = self::GetAlias(false, true);
        self::SetModelTable('messages_content');
        $select[] = DB::raw('(select '.self::GetAlias(false, true).'content from '.self::GetAlias(true, true).' where '.self::GetAlias(false, true).'id = '.$alias.'id) as content');
        $select[] = DB::raw('(select '.self::GetAlias(false, true).'images from '.self::GetAlias(true, true).' where '.self::GetAlias(false, true).'id = '.$alias.'id) as images');
        self::SetModelTable('messages');
        $select[] = self::GetAlias().'name';
        $select[] = self::GetAlias().'id';
        $select[] = self::GetAlias().'image';
        $select[] = self::GetAlias().'writer';
        $select[] = self::GetAlias().'weight';
        $select[] = self::GetAlias().'click';
        $select[] = self::GetAlias().'keywords';
        $select[] = self::GetAlias().'unique';
        $select[] = self::GetAlias().'description';
        $select[] = self::GetAlias().'update_time';
        $select[] = self::GetAlias().'page';
        $model = new self;
        $model = $model->select($select);
        $model = $model->where(self::GetAlias().'columns_id', $columnId);
        $model = $model->where(self::GetAlias().'is_del', 0);
        $model = $model->where(self::GetAlias().'release', 1);
        $model = $model->when(self::hasTableIndex(self::GetAlias(true, true).'_columns_id_index'),function ($query){
            $query->from(DB::raw('`'. self::GetAlias(true, true) .'` FORCE INDEX (`cc_messages_columns_id_index`)'));
        });
        return $model->get()->each(function ($item){
            $tags = array_map(function ($tag){
                return $tag['tname'];
            }, self::tags($item->unique));
            $item['content'] = is_null($item['content']) ? '' : $item['content'];
            $item['images'] = is_null($item['images']) ?  [] : explode(',', $item['images']);
            $item['tag'] = implode(',', $tags);
        })->toArray();
    }

    /**
     * 信息(上一页和下一页)
     *
     * @param int $columnId
     * @param array $order
     * @param int $value
     * @return array
     */
    public static function messageEnter(int $columnId, array $order, int $value): array
    {
        $model = new self;
        $model = $model->select(self::GetAlias().'id', self::GetAlias().'name', self::GetAlias().'page');
        $model = $model->where(self::GetAlias().'columns_id', $columnId);
        $model = $model->where(self::GetAlias().'is_del', 0);
        $model = $model->where(self::GetAlias().'release', 1);
        $model = $model->where(self::GetAlias().$order['select'], $order['condition'], $value);
        $model = $model->orderBy(self::GetAlias().$order['select'], $order['value']);
        $model = $model->limit(1);
        return $model->get()->toArray();
    }
}
