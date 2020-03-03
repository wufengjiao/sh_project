<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialCategory extends Model
{
    /*
     * 材料类别表
     */

//    protected $table="materialcategory";
//
//    protected $fillable=['id','category_name'];

    public function __construct(array $attributes = [])
    {
        $connection = Config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable('material_category');

        parent::__construct($attributes);
    }
    /**
     * 组合所有的材料类别
     */
    public static function getAllCategory(){
        $data = array();
        //查询所有
        $categorys = Materialcategory::all();

        //分类处理
        foreach ($categorys as $category){
            $data[$category['id']] = $category['category_name'];
        }
        return $data;
    }
}
