<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    //地区表
    public function __construct(array $attributes = [])
    {
        $connection = Config('admin.database.connection') ?:config('database.default');

        $this->setConnection($connection);

        $this->setTable('area');

        parent::__construct($attributes);
    }
    /**
     * 地区
     */
    public static function getAllArea(){
        $data = array();
        $areas = Area::all(['code','name']);

        foreach ($areas as $area){
            $data[$area['code']] = $area['name'];
        }
        return $data;
    }
}
