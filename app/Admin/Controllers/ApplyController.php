<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Apply;
use App\Models\Materialcategory;
use App\Models\Project;
use Doctrine\DBAL\Schema\Table;
use Encore\Admin\Admin;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use Encore\Admin\Grid;

class ApplyController extends Controller
{
    use HasResourceActions;

    /**
     * 材料申请表
     */
    /**
     * 项目成本控制--采购记录首页
     */
    public  function index(Content $content){
        return $content->header(trans('项目成本控制'))
            ->description(trans('材料采购记录'))
            ->body($this->grid()->render());

    }

    public function grid(){
        $grid = new Grid(new Apply());

        $grid->number('采购编号');
        $grid->title('采购小标题');
        $grid->column('project_id','项目名称')->display(function (){
            //通过project表获取项目名称
            $project_name = Project::query()->find($this->project_id);
            return $project_name;
        });
        $grid->money('申请金额/(万)');
        $grid->status('审批状态');
        $grid->create_at('申请时间');

        //处理操作栏
        $grid->actions(function (Grid\Displayers\Actions $actions){
            $actions->disableEdit();
        });

//        $grid->disableCreateButton();

        //处理头部按钮
        $grid->tools(function (Grid\Tools $tools) {
            $tools->batch(function (Grid\Tools\BatchActions $actions) {
                $actions->disableDelete();
            });

        });

        //处理过滤器
        $grid->filter(function (Grid\Filter $filter){
            //处理筛选条件
            $filter->disableIdFilter();

            $filter->like('number','采购编号');
            $filter->where(function ($query) {
                $project = Project::query()->where('project_name','like',"%{$this->input}%")->first();
                $query->Where('project_id', '=', $project['id']);
            }, '项目名称')->placeholder('项目名称');
            $filter->between('create_at','申请时间')->datetime();
        });

        return $grid;
    }

    /**
     * 项目成本控制--材料采购申请表格
     */
    public function create(Content $content){

        // 随机生成采购编号
        $rand_number = date('YmdHis',time());

        //获取系统项目--筛选出正在开发中的项目
        $projects = Project::query()->where('status','=',0)->get(['id','project_name']);

        //材料类别
        $category = Materialcategory::all(['id','category_name']);

        return view('apply.apply')
            ->with(['header'=>trans('材料采购申请'),'number'=>$rand_number,'projects'=>$projects,'category'=>$category]);
    }

    /**
     * 采购材料申请处理
     * @Request 申请表单内容
     * @return
     */
    public function store(Request $Request){
        var_dump($Request->all());die;
    }
}
