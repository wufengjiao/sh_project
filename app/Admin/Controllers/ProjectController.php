<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Apply;
use App\Models\Project;
use App\Models\ProjectUser;
use Encore\Admin\Admin;
use Encore\Admin\Auth\Database\Role;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ProjectController extends Controller
{
    use HasResourceActions;

    /*
     * 项目预结算首页
     */
    public function index(Content $content)
    {
        return $content
            ->header(trans('项目预结算'))
            ->description(trans('首页'))
            ->body($this->grid()->render());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Project());

        $grid->project_sn('项目编号');
        $grid->project_name('项目名称');
        $grid->contract_price('合同价/(万)')->display(function ($contract_price) {
            return $contract_price;
        })->setAttributes(["style" => "background-color:#99FFCC"]);

        //若需要经过复杂逻辑，可使用display方法修改输出
        $grid->column('expected_pay', '期望预算/(万)')->display(function () {
            $result = $this->contract_price * (1 - $this->perprofit / 100);
            return $result;
        });
        $grid->column('real_pay', '已用预算/(万)')->display(function () {
            $result = $this->real_labor + $this->real_materials + $this->real_others;
            return $result;
        })->setAttributes(["style" => "background-color:#99FFCC"]);
        $grid->column('expected_profit', '期望利润/(万)')->display(function () {
            $result = $this->contract_price * ($this->perprofit / 100);
            return $result;
        })->setAttributes(['background-color' => '99FFCC']);
        $grid->column('实际盈余/(万)')->display(function () {
            $result = $this->contract_price - ($this->real_labor + $this->real_materials + $this->real_others);
            return $result;
        })->setAttributes(["style" => "background-color:#99FFCC"]);

        $grid->column('status','开发状态')->display(function (){
            return  $this->status==0?"开发中":"已完工";
        });

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
            $actions->prepend("<a href='/admin/project/{$actions->getKey()}/allview'><i class='fa fa-eye'></i></a>");
//                    $actions->prepend("<a href='/admin/project/{$actions->getKey()}/allview'><i class='fa fa-eye'></i></a>");
        });
        $grid->tools(function (Grid\Tools $tools) {
            $tools->batch(function (Grid\Tools\BatchActions $actions) {
                $actions->disableDelete();
            });
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

    /*
     * 项目预结算新增项目
     */
    public function create(Content $content)
    {
        return $content
            ->header(trans('项目预结算'))
            ->description(trans('新增项目'))
            ->body($this->form());
    }

    /**
     * Make a form builder.
     * @return Form
     */
    public function form()
    {
        $form = new Form(new Project());

        $form->tools(function (Form\Tools $tools){
            $tools->disableView();
        });

        //项目内容
        $form->tab('基础信息', function ($form) {
            $project_sn = date("YmdHis",time());
            $form->text('project_sn', trans('项目编号'))->attribute('readonly')->default($project_sn)->rules('required');
            $form->text('project_name', trans('项目名称'))->rules('required');
            $form->text('contract_price', trans('合同价/万'))->rules('required');
            $form->rate('perprofit', trans('期望利润'))->rules('required');
            $form->text('expected_labor', trans('人工成本/万'))->rules('required')
                  ->attribute('style', 'background-color:#CCCCCC');
            $form->text('expected_others', trans('其他成本/万'))->rules('required')
                  ->attribute('style', 'background-color:#CCCCCC');
            $form->text('expected_materials', trans('材料成本/万'))->rules('required')
                  ->attribute('style', 'background-color:#CCCCCC')
                  ->attribute('readonly');
            $form->distpicker(['province_code' => '省','city_code' => '市','district_code' => '区'],'项目省份')->autoselect(3);
            $form->text('address',trans('项目详细地址'))->rules('required');
            $form->radio('status', trans('开发状态'))->options([0 => '开发中', 1=> '已完工'])->default(0);
            $form->datetime('start_time','开工时间');
            $form->datetime('end_time','完工时间');
            $form->textarea('remark','备注')->rows(3);

        })->tab('参与人员', function ($form) {

            //admin_url 或者是 admin_base_path 都可以
            $form->hidden('workflow_id');
            $form->multipleSelect('workflow_id[0]', trans('总经理'))->options(admin_base_path('auth/users/president/findPerson'));
            $form->multipleSelect('workflow_id[1]', trans('项目总监'))->options(admin_base_path('auth/users/inspector/findPerson'));
            $form->multipleSelect('workflow_id[2]', trans('项目经理'))->options(admin_base_path('auth/users/manager/findPerson'));
            $form->multipleSelect('workflow_id[3]', trans('施工助手'))->options(admin_base_path('auth/users/assistant/findPerson'));
            $form->multipleSelect('workflow_id[4]', trans('采购人员'))->options(admin_base_path('auth/users/purchase/findPerson'));
            $form->multipleSelect('workflow_id[5]', trans('财务人员'))->options(admin_base_path('auth/users/finance/findPerson'));
        });

        $this->script = <<<SCRIPT
                $(".expected_labor,.expected_others").blur(function () {
                    var id=$(this).attr("id");

                   //合同总价
                    var contract_price = document.getElementById("contract_price").value;
                    var perprofit  = document.getElementById("perprofit").value;
                    if(isNaN(contract_price)){
                        document.getElementById("contract_price").setAttribute("style","color:red");
                    }
                     if(isNaN(perprofit)){
                        document.getElementById("perprofit").setAttribute("style","color:red");
                    }
                    var expected = contract_price * ( perprofit / 100);
                    //输入成本价格
                    var expected_labor = isNaN(document.getElementById("expected_labor").value)?0:Number(document.getElementById("expected_labor").value);
                    var expected_others = isNaN(document.getElementById("expected_others").value)?0:Number(document.getElementById("expected_others").value);

                    var cur_sum = expected_labor + expected_others;
                    if(cur_sum > expected){
                         document.getElementById(id).setAttribute("style","color:red");
                         $(".btn-primary").attr('disabled',true);
                    }else{
                         //填充材料成本的值
                         var expected_materials = expected - cur_sum;
                         $(".expected_materials").val(expected_materials);
                         document.getElementById(id).removeAttribute("style");
                         document.getElementById(id).setAttribute("style","background-color: #CCCCCC");
                         $(".btn-primary").attr('disabled',false);
                    }
                });
SCRIPT;
        Admin::script($this->script);
        $form->saving(function(Form $form){
            $data = Input::all();
            //项目开始时间、结束时间
            if ( strtotime($data['start_time']) > strtotime($data['end_time']) ){
                throw new \Exception("添加时间错误");
            }
            $form->start_time = strtotime($data['start_time']);
            $form->end_time = strtotime($data['end_time']);
            $form->workflow_id = serialize($data['workflow_id']);

        });

        return $form;
    }

    /**
     * 项目预结算编辑
     *
     * @param $id
     *
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header(trans('项目预结算'))
            ->description(trans('编辑'))
            ->body($this->form()->edit($id));
    }

    /**
     * 项目预结算总览
     * @param $id
     * @return Content
     */
    public function allview($id, Content $content){
        $data = Project::query()->find($id);
        $project_data = [];
        $project_data[0] = ['人工总费用',$data['expected_labor'],$data['real_labor']];
        $project_data[1] = ['材料总费用',$data['expected_materials'],$data['real_materials']];
        $project_data[2] = ['其他总费用',$data['expected_others'],$data['real_others']];

        return view('project.allview')->with('header','项目预结算')->with("project_data",$project_data);
    }

    /**
     * 获取项目指定材料成本的期望值、已使用的值、和正在申请中的值
     * @param $id 项目id
     * @return array
     */
    public function getprogress(Request $request){
        $content = $request->all();
        $result = array();
        //获取指定项目
        $project = Project::query()->select(['id','expected_materials','real_materials'])->find($content['id']);
dd($project);
        //添加期望成本值、实际已使用值
        $result['expected'] = $project['expected_materials'];
        $result['real'] = $project['real_materials'];

        //统计申请表中处于申请状态的批次
        $sum_apply_money = Apply::query()->where('project_id','=',$content['id'])
                                         ->where('status','=',0)->sum('money');
        $result['apply'] = $sum_apply_money;

        return $result;
    }

    /**
     * 通过id查询用户角色
     * @param $user_id
     * @param $project_id
     * @return string
     */
    public function findRole($user_id,$project_id){
        $result = "";
        //查找到指定项目下，指定用户的当前角色id
        $projectuser = ProjectUser::query()->select(['role_id'])->where('project_id','=',$project_id)
                                                                ->where('user_id','=',$user_id);
        var_dump($projectuser);die;
        $role = Role::query()->find($projectuser->role_id)->get(['']);
        return $result;
    }
}
