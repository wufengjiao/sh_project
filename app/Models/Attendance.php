<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    /**
     * 项目监管表
     */
    public function __construct(array $attributes = [])
    {
        $connection = Config('admin.database.connection') ?: config('database.default');
        $this->connection = $connection;
        $this->setTable('attendance');
        parent::__construct($attributes);
    }
}
