<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conclu extends Model
{
    /**
     * 项目总结表
     */
    public function __construct(array $attributes = [])
    {
        $connection = Config('admin.database.config')?:Config('"admin.database.config"');
        $this->connection = $connection;
        $this->setTable('conclu');
        parent::__construct($attributes);
    }
}
