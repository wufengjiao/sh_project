<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Materialcategory;
use App\Models\Material;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use Encore\Admin\Grid;
use Illuminate\Support\Facades\DB;

class MaterialController extends Controller
{
    use HasResourceActions;

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

        $category_data = Materialcategory::getAllCategory();
        $grid->category_id('材料类别')->using($category_data);
        $grid->merchant('商家名称');
        $grid->address('商家地址');//to do
        $grid->unit('单位');
        $grid->market_price('市场价');
        $grid->grade('质量评分');
        $grid->linkname('联系人姓名');
        $grid->linktel('联系人电话');

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

            $filter->where(function ($query) {
                $category = Materialcategory::query()->where('category_name','like',"%{$this->input}%")->first();
                $query->Where('category_id', '=', $category['id']);
            }, '材料类别')->placeholder('材料类别');

            $filter->like('merchant','商家名称');

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
        $data = Materialcategory::all();
        foreach ($data as $option){
            $result[$option['id']] = $option['category_name'];
        }

        //项目内容
        $form->select('category_id','材料类别')->options($result)->rules('required');;
        $form->text('merchant','商家名称')->rules('required');
        $form->text('address','商家地址')->rules('required');//to do
        $form->text('unit','单位')->rules('required');
        $form->text('market_price','市场价/(元)')->rules('required');
        $form->number('grade','质量评分')->min(0)->max(10)->rules('required');
        $form->text('linkname','联系人姓名')->rules('required');
        $form->mobile('linktel','联系人电话')->rules('required');
//        $form->hidden('_token')->default(csrf_token());//to do


        return  $form;
    }

    /**
     * 项目成本控制--储存新建材料库表单数据
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        try{
            DB::beginTransaction();
            $data = $request->all();

            $insert_data = array();
            $insert_data['category_id'] = (int)$data['category_id'];
            $insert_data['merchant'] = $data['merchant'];
            $insert_data['address'] = $data['address'];
            $insert_data['unit'] = $data['unit'];
            $insert_data['market_price'] = floatval($data['market_price']);
            $insert_data['grade'] = $data['grade'];
            $insert_data['linkname'] = $data['linkname'];
            $insert_data['linktel'] = $data['linktel'];
            //判断数据是否已存在
            $if_have = Material::query()->where('category_id',"=",$insert_data['category_id'])
                                    ->Where('merchant',"=",$insert_data['merchant'])
                                    ->Where('address',"=",$insert_data['address'])
                                    ->Where('unit',"=",$insert_data['unit'])
                                    ->Where('market_price',"=",$insert_data['market_price'])->get();
            if(count($if_have) != 0){
               throw new \Exception("数据已存在");
            }
            $result = Material::query()->insertGetId($insert_data);
            if (!$result){
                throw new \Exception("材料添加失败");
            }
            DB::commit();

            return redirect("/admin/materials/market")->with(trans('材料添加成功'));

        }catch(\Exception $e){
            DB::rollBack();
            echo 'Caught exception: ',  $e->getMessage(),'<br>';
        }
    }


    /**
     * 项目成本控制--编辑材料库数据
     * @param $id
     *
     * @return Content
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
    public function getLowprice($material_id){
        var_dump($material_id,34343);die;

    }
}
