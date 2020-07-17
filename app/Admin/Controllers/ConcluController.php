<?php
namespace App\Admin\Controllers;

use App\Models\Conclu;
use App\Models\Project;
use App\Models\ProjectUser;
use App\User;
use Encore\Admin\Admin;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;
use Encore\Admin\Grid;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\DB;


class ConcluController extends Controller
{
    use ModelForm;

    /**
     *项目总结
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
        $grid->column(trans('实际盈余/万'))->display(function (){
            $result = $this->contract_price -($this->real_labor + $this->real_materials + $this->real_others);
            return $result;
        });//实际盈余

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
            $actions->prepend("<a href='/admin/conclu/{$actions->getKey()}/view'>查看</a>");

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
     *项目总结--具体项目查看
     * $id 项目id
     */
    public function view($id,Content $content){
        //查找指定项目对应的名称
        $project = Project::query()->select(['id','project_name'])->find($id);

        return $content->header(trans('项目总结'))
                        ->description($project['project_name']."/查看")
                        ->body($this->gridview($id)->render());

    }

    public function gridview($id){
        $grid = new Grid(new Conclu());
        $grid->model()->where('project_id','=',$id);
        $grid->column('评价对象')->display(function (){
            $user = User::query()->select(['id','name'])->find($this->to_user_id);
            return $user['name'];
        });//评价对象
        $grid->roles(trans('职位角色'))->pluck('name')->label();//职位
        $grid->grade('评分');//星星显示评分 to do
        $grid->remark('备注');//备注

        //删除操作工具
        $grid->tools(function (Grid\Tools $tools){
            $tools->disableFilterButton();
            $tools->disableBatchActions();
            $new_url = str_replace('view','create',$this->grid()->resource());
            $tools->append("<a href='{$new_url}' style='float: right;margin-right: 20px;' class='btn btn-sm btn-success'>
                                    <i class='fa fa-save'></i>&nbsp;&nbsp;新建评价</a>");
        });
        //删除新增键
        $grid->disableCreateButton();
        //删除查看操作
        $grid->actions(function (Grid\Displayers\Actions $actions,$id){
            $actions->disableView();
        });
        return $grid;
    }

    /**
     * 新建评价页面
     * $project_id 工程id
     */
    public function create($project_id,Content $content){
        //工程信息
        $project = Project::query()->select(['id','project_name'])->find($project_id);

//        return View('conclu.create')->with(['users'=>$users,'roles'=>$roles,'project'=>$project]);
        return $content->header(trans('项目总结'))
                       ->description($project['project_name'].'新建评价')
                       ->body($this->form($project_id));
    }
    public function form($project_id){
        $form = new Form(new Conclu());
        $result_users = [];
        $result_roles = [];
        //评论对象
        $sql = 'SELECT id,name FROM sh_users  where id in (SELECT user_id from sh_project_users where project_id = :project_id)';
        $users = DB::select($sql,[':project_id'=>$project_id]);
        //处理users
        foreach ($users as $user){
            $result_users[$user->id] = $user->name;
        }
       /* //角色
        $roles = Role::query()->get(['id','name']);
        foreach ($roles as $role){
            if (!stristr($role->name,'Administrator')){
                //除去超级管理员
                $result_roles[$role->id] = $role->name;
            }
        }*/
        $form->setAction('store');
        $form->select('user_id',trans('评价对象'))->options($result_users)->rules('required');//评价对象
        $form->text('role_id','职位')->rules('required')->readOnly();//职位

        $this->script = <<<EOT
                $(".user_id").change(function(){
                    //获取到评论对象id
                    var user_id = $(".user_id option:selected").val();
                    //评论项目id
                    var project_id = $("#project_id").val();
                    //通过user_id获取该对象的角色
                    $.ajax({
                        type:"GET",
                        datatype:"JSON",
                        contentType:'application/json',
                        url:"/admin/project/findRole",
                        data:{
                             user_id:user_id,
                             project_id:project_id,
                        },
                        success:function(data){
                           
                        },
                    });
                });
EOT;

        Admin::script($this->script);
        return $form;
    }
}
