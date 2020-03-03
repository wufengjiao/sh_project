<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'ProjectController@index');//登录之后跳转页面

    //项目预结算
    $router->post('project/store', 'ProjectController@store');
    $router->get('project/{id}/allview', 'ProjectController@allview');
    $router->get('project/getprogress', 'ProjectController@getprogress');
    $router->get('project/findRole', 'ProjectController@findRole');
    $router->resource('project', 'ProjectController');
//    $router->resource('project', ProjectController::class); 均可

    //项目成本控制--材料库
    $router->get('material/getLowprice', 'MaterialController@getLowprice');
    $router->resource('material', 'MaterialController');

    //项目成本控制--材料采购记录
    $router->post('apply/store', 'ApplyController@store');
    $router->resource('apply', 'ApplyController');

    //项目监管
    $router->get('attendance/{id}/view','AttendanceController@view');//查看具体项目的考勤情况
    $router->get('attendance/{id}/create','AttendanceController@create');//新建具体项目的每日考勤
    $router->resource('attendance','AttendanceController');

    //项目总结
    $router->get('conclu/{id}/view','ConcluController@view');//查看具体项目的总结情况
    $router->get('conclu/{id}/create','ConcluController@create');//新建具体项目的单个总结
    $router->resource('conclu','ConcluController');
});
