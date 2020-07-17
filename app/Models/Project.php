<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    /**
     *工程表
     */
    public function __construct(array $attributes = [])
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable('project');

        parent::__construct($attributes);
    }


    public function getStartTimeAttribute($value)
    {
        return date('Y-m-d H:i:s',$value);
    }

    public function getEndTimeAttribute($value)
    {
        return date('Y-m-d H:i:s',$value);
    }

}
