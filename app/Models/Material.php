<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use League\Flysystem\Config;

class Material extends Model
{
    /*
     * 材料库表
     */
    public function __construct(array $attributes = [])
    {
        $connection = Config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable('material');

        parent::__construct($attributes);
    }
}
