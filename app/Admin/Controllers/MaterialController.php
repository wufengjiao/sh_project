<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Materialcategory;
use App\Models\Material;
use App\Models\Project;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;
use Encore\Admin\Grid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class MaterialController extends Controller
{
    use HasResourceActions;
    protected $states = [
        'off'  => ['value' => 0, 'text' => '关闭', 'color' => 'default'],
        'on' => ['value' => 1, 'text' => '打开', 'color' => 'primary'],
    ];
    protected $enable;
    public function __construct()
    {
        $this->enable = [0=>trans('禁用'),1=>trans('启用')];
    }

    /**
     * 项目成本--材料库
     */
    public function index(Content $content){
        return $content->header(trans('项目成本控制'))
                        ->description(trans('材料库'))
                        ->body($this->grid()->render());

    }

    protected function grid(){
        $grid = new Grid(new Material());

        $categorys = Materialcategory::getAllCategory($flag=1);
        $grid->category_id(trans('材料类别'))->using($categorys);
        $grid->merchant(trans('商家名称'));
        $grid->column(trans('商家地址'))->display(function (){
            $areas = Area::getAllArea();
            $province = empty($areas[$this->province_code])?'':$areas[$this->province_code];
            $city = empty($areas[$this->city_code])?'':$areas[$this->city_code];
            $distric = empty($areas[$this->district_code])?'':$areas[$this->district_code];

            $result = $province .' '.  $city .' '.  $distric .' '. $this->address;
            return $result;
        });

        $grid->unit(trans('单位'));
        $grid->market_price(trans('市场价'));
        $grid->grade(trans('质量评分'));
        $grid->linkname(trans('联系人姓名'));
        $grid->linktel(trans('联系人电话'));

        // 设置text、color、和存储值
        $grid->column('enable',trans('启用状态'))->switch($this->states);

        $grid->tools(function (Grid\Tools $tools) {
            //删除搜索栏选中功能
            $tools->disableBatchActions();
        });

        $grid->actions(function (Grid\Displayers\Actions $actions){
            //删除之前的操作栏选项
            $actions->disableView();
            $actions->disableEdit();

            $actions->prepend("<a href='/admin/material/{$actions->getKey()}/edit'><i class='fa fa-edit'></i></a>");
        });

        //表格筛选
        $grid->filter(function (Grid\Filter $filter){
            $filter->disableIdFilter();

            $filter->where(function ($filter) {
                $category = Materialcategory::query()->where('category_name','like',"%{$this->input}%")->first(['id']);
                $filter->where('category_id', '=', $category['id']);

                //To Do 1 模糊查询多条数据
                // $category = DB::select("select id from sh_material_category where category_name like '%$this->input%' ");
                // $ids = array_column($category,'id');
                // $filter->where('category_id', 'in', $ids);

            }, trans('材料类别'))->placeholder(trans('请输入材料类别'));

            $filter->like('merchant',trans('商家名称'))->placeholder(trans('请输入商家名称'));

        });

        return $grid;
    }

    /*
    * 项目成本控制--新建材料库数据
    */
    public function  create(Content $content)
    {
        return $content
            ->header(trans('项目成本控制'))
            ->description(trans('新建材料库数据'))
            ->body($this->form());
    }

    /**
     * Make a form builder.
     * @return Form
     */
    public function form(){
        $form = new Form(new Material());
        $data = Materialcategory::getAllCategory();

        $form->tools(function (Form\Tools $tools){
            $tools->disableView();
        });
        //项目内容
        $form->select('category_id','材料类别')->options($data)->rules('required');
        $form->text('merchant','商家名称')->rules('required');
        $form->distpicker(['province_code' => '省','city_code' => '市','district_code' => '区'], '商家省份')->autoselect(3);
        $form->text('address','商家详细地址')->rules('required');
        $form->text('unit','单位')->rules('required');
        $form->text('market_price','市场价/(元)')->rules('required');
        $form->number('grade','质量评分')->min(0)->max(10)->rules('required');
        $form->text('linkname','联系人姓名')->rules('required');
        $form->mobile('linktel','联系人电话')->rules('required');
        $form->switch('enable',trans('启用状态'))->states($this->states);

        $form->saving(function (Form $form){
            $insert_data = Input::all();
            $id = $form->model()->id;
            $flag = false;
            $if_have = Material::where('category_id',"=",$insert_data['category_id'])
                                            ->Where('merchant',"=",$insert_data['merchant'])
                                            ->Where('province_code',"=",$insert_data['province_code'])
                                            ->Where('city_code',"=",$insert_data['city_code'])
                                            ->Where('district_code',"=",$insert_data['district_code'])
                                            ->Where('address',"=",$insert_data['address'])
                                            ->Where('unit',"=",$insert_data['unit'])
                                            ->Where('market_price',"=",$insert_data['market_price'])
                                            ->get(['id'])->toArray();

            if(count($if_have) != 0){
                if((!empty($id) && $id != $if_have[0]['id']) || (empty($id) && count($if_have[0]) != 0)){
                    $flag = true;
                }
            }
            if($flag){
                throw new \Exception(trans('该商家材料已存在'));
           }
        });

        return  $form;
    }


    /**
     * 项目成本控制--编辑材料库数据
     * @param $id
     */
    public function edit($id,Content $content){
        return $content
            ->header(trans('项目预结算'))
            ->description(trans('编辑'))
            ->body($this->form()->edit($id));
    }

    /**
     * 获取对应材料类别的最低价
     * @material_id 材料类别的id
     * @return result
     */
    public function getLowprice(Request $request){
        $data = $request ->all();
        //获取当前工程的地区
        $project = Project::select('province_code','city_code','district_code')->find($data['project_id'])->toArray();//可能为空,标准查询
        $lowest_material = '';

        if(!empty($project)){
            // 获取  当地工程  指定材料的最低价--评分为前提下的最低分
            $lowest_material = Material::where('province_code','=',$project['province_code'])
            ->where('city_code','=',$project['city_code'])
            ->where('district_code','=',$project['district_code'])
            ->where('category_id','=',$data['category_id'])
            ->where('enable','=',1)
            ->orderby('grade','desc')
            ->orderby('market_price','asc')
            ->first(['id','merchant','market_price','grade'])->toArray();
        }

        return $lowest_material;
    }
}
