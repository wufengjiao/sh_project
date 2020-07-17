<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apply extends Model
{
    /*
     * 材料申请表
     */

    public function __construct(array $attributes = [])
    {
        $connection = Config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable('apply');

        parent::__construct($attributes);
    }
}
