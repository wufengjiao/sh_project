<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('role', function (Blueprint $table) {
//            $table->increments('id');
//            $table->timestamps();
//        });

        Schema::create('user', function (Blueprint $table) {//用户表
            $table->engine = 'InnoDB';//指定表类型
            $table->increments('user_id');//用户id
            $table->string('user_name', 190)->unique();//用户姓名
            $table->string('user_password', 60)->nullable(false)->change();//用户登录密码
            $table->integer('user_login_num');//用户登录总次数
            $table->string('local_ip',190);//用户最近登录ip
            $table->integer('user_power_id')->default(1);//用户权限角色
            $table->time('user_create_time');//用户插入时间
        });
        Schema::create('power', function (Blueprint $table) {//权限表
            $table->engine = 'InnoDB';//指定表类型
            $table->increments('power_id');//权限id
            $table->string('power_name', 190)->unique();//权限名称
            $table->text('power_content', 60)->nullable(false)->change();//权限内容
            $table->time('power_create_time');//权限插入时间
        });
        schema::create('menu',function (Blueprint $table){//菜单表
            $table->engine = 'InnoDB';//指定表类型
            $table->increments('menu_id');//菜单id
            $table->integer('menu_pid')->default(1);//父级菜单id
            $table->string('menu_name',190)->nullable(false)->change();//菜单名称
            $table->tinyInteger('menu_level');//菜单级别
            $table->string('menu_controller')->nullable(true);//菜单控制器
            $table->string('menu_action')->nullable(true);//菜单方法
            $table->tinyInteger('menu_status');//菜单级别
            $table->time('menu_create_time');//权限插入时间
        });

        schema::create('index',function (Blueprint $table){//菜单表
            $table->engine = 'InnoDB';//指定表类型
            $table->increments('project_id');//项目id
            $table->string('project_sn');//项目编号
            $table->string('project_name',190)->nullable(false)->change();//项目名称
            $table->decimal('project_contract_price',10,2);//项目合同价格
            $table->decimal('project_perprofit',4,2)->nullable(true);//项目利润百分比
            $table->decimal('Project_expeted_labor',10,2);//项目期望人工成本
            $table->decimal('project_expected_materials',10,2);//项目期望材料成本
            $table->decimal('project_expected_others',10,2);//项目期望其他成本

            $table->decimal('project_real_labor',10,2);//项目实际人工成本
            $table->decimal('project_real_materials',10,2);//项目实际材料成本
            $table->decimal('project_expected_others',10,2);//项目实际其他成本

            $table->time('project_start_time');//开工时间
            $table->time('project_end_time');//完工时间

            $table->tinyInteger('project_province');//项目施工地点省
            $table->tinyInteger('project_city');//项目施工地点市
            $table->tinyInteger('project_area');//项目施工地点区
            $table->tinyInteger('project_address');//项目施工地点具体位置

            $table->text('project_remark');//项目备注
            $table->time('project_create_time');//插入时间
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::dropIfExists('role');
        Schema::dropIfExists('user');
        Schema::dropIfExists('power');
        Schema::dropIfExists('menu');
        Schema::dropIfExists('index');
    }
}
