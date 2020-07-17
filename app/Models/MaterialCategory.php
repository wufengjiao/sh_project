<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use League\Flysystem\Config;

class MaterialCategory extends Model
{
    /*
     * 材料类别表
     */

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
    public static function getAllCategory($flag = 0){
        $data = array();
        if($flag == 1) $data[0] = '无';
        //查询所有
        $categorys = self::all(['id','category_name']);
       
        foreach ($categorys as $category){
            $data[$category['id']] = $category['category_name'];
        }

        return $data;
    }
}
