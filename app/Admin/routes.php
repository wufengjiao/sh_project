<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index');//登录之后跳转页面

    //项目预结算
    $router->resource('project', 'ProjectController');
    $router->get('project/{id}/allview', 'ProjectController@allview');
    $router->post('project/getprogress', 'ProjectController@getprogress');
    $router->get('project/findRole', 'ProjectController@findRole');

    //项目成本控制--材料类别
    $router->resource('materialcategory','MaterialCategoryController');

    //项目成本控制--材料库
    $router->resource('material', 'MaterialController');
    $router->post('material/getLowprice', 'MaterialController@getLowprice');

    //项目成本控制--材料采购记录
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
