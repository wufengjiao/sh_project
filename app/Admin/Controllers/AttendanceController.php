<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Project;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;


class AttendanceController extends Controller
{
    use ModelForm;

    /*
     * 项目监管首页
     */
    public function index(Content $content)
    {
        return $content->header(trans('项目监管'))
            ->description(trans('工程考勤'))
            ->body($this->grid()->render());
    }

        public function grid(){
        $grid = new Grid(new Project());
        $grid->project_sn(trans('项目编号'));//项目编号
        $grid->project_name(trans('项目名称'));//项目名称

        $grid->tools(function (Grid\Tools $tools) {
            $tools->batch(function (Grid\Tools\BatchActions $actions) {
                $actions->disableDelete();
            });
        });
        $grid->disableCreateButton();
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableEdit();
            $actions->disableDelete();
            $actions->disableView();
            $actions->prepend("<a href='/admin/attendance/{$actions->getKey()}/view'>查看</a>");

        });
        //表格筛选
        $grid->filter(function (Grid\Filter $filter) {
            $filter->disableIdFilter();
            $filter->where(function ($query) {
                $query->where('project_sn', 'like', "%{$this->input}%")
                    ->orWhere('project_name', 'like', "%{$this->input}%");
            }, '搜索关键词')->placeholder(' 项目编号 / 项目名称');
        });
        return $grid;
    }

    /**
     * 项目监管--工程考勤查看
     * @param $id 项目id
     * @return Content
     */
    public function view($id,Content $content){
        //查找指定项目对应的名称
        $project = Project::query()->select(['id','project_name'])->find($id);

        return $content->header(trans('项目监管'))
            ->description($project['project_name']."/查看")
            ->body($this->gridview($id)->render());
    }

    public function gridview($id){
        $grid = new Grid(new Attendance());
        $grid->model()->where("project_id",'=',$id);
        $grid->number('序号');
        $grid->rows(function ($row, $number) {
            $row->column('number', $number+1);
        });
        $grid->create_at("日报时间");
        $grid->daily_content("日报内容");
        $grid->column('daily_content_pic','日报结果凭证')->display(function () {
            $img = "";
            if (!empty($this->daily_content_pic)){
                $img = "<img src='base_path($this->daily_content_pic)' id='daily_content_pic' style='width: 40px;height: 40px;'>";
            }
            return $img;
        });
        $grid->disableCreateButton();
        $grid->tools(function (Grid\Tools $tools) {
            $tools->disableBatchActions();
            $tools->disableRefreshButton();
//            $tools->prepend('<a class="btn btn-sm btn-default form-history-bac" href="#" onClick="javascript :history.back(-1);">
//                        <i class="fa fa-arrow-left"></i>&nbsp;返回</a>');
            $tools->prepend('<a class="btn btn-sm btn-default form-history-bac" href="/admin/attendance/">
                        <i class="fa fa-arrow-left"></i>&nbsp;返回</a>');
            $new_url = str_replace('view','create',$this->grid()->resource());
            $tools->prepend("<a href='$new_url' style='float: right;margin-right: 20px;' class='btn btn-sm btn-success'>
                                    <i class='fa fa-save'></i>&nbsp;&nbsp;添加日报</a>");
        });

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableEdit();
            $actions->disableDelete();
            $actions->disableView();
            $actions->append("<a href='/admin/attendance/{$actions->getKey()}/view'><i class='fa fa-eye'></i></a>");
            $actions->append("<a href='javascript:void(0)' data-id={$actions->getKey()} class='grid-row-delete'>
                                        <i class='fa fa-trash'></i></a>");

        });

        //表格筛选
        $grid->filter(function (Grid\Filter $filter) {
            $filter->disableIdFilter();
            $filter->between('create_at', '日报时间')->datetime();
        });

        return $grid;
    }
}
