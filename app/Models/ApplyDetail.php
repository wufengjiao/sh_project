<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplyDetail extends Model
{
    /*
     * 材料申请详细表
     */
    public function __construct(array $attributes = [])
    {
        $connection = Config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable('apply_detail');

        parent::__construct($attributes);
    }
}
