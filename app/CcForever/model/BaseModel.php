<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/20
 */
namespace App\CcForever\model;


use App\CcForever\traits\AffairTrait;
use App\CcForever\traits\ModelTraits;
use Illuminate\Database\Eloquent\Model;

/**
 * Model基类
 * Class BaseModel
 * @package App\CcForever\model
 */
 class BaseModel extends Model
{
    use AffairTrait,ModelTraits;

     protected $primaryKey; // 表主键

     protected $table;// 模型对应的表名

     public $timestamps = false; // 不自动更新 created_at 和 updated_at

 }