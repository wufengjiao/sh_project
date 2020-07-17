<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MaterialCategory;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Exception;
use Illuminate\Support\Facades\Input;

class MaterialCategoryController extends Controller
{
    use HasResourceActions;

    /*
    * 项目材料类别-首页
    */
    public function index(Content $content){
        return $content->header(trans('项目成本'))
                        ->description(trans('项目材料类别'))
                        ->body($this->grid()->render());
    }

    protected function Grid(){
        $grid = new Grid(new MaterialCategory());
        $categorys = Materialcategory::getAllCategory($flag=1);

        $grid->category_name(trans('材料名称'));

        $grid->pid(trans('父级材料名称'))->using($categorys);

        $grid->tools(function (Grid\Tools $tools){
            $tools->disableBatchActions();
        });

        $grid->actions(function (Grid\Displayers\Actions $actions){
            $actions->disableView();
        });

        $grid->filter(function (Grid\Filter $filter){
            $filter->disableIdFilter();
            $filter->like('category_name',trans('材料名称'));
        });
        return $grid;
    }

    /*
    *项目材料类别-新增
    */
    public function create(Content $content){
        return $content->header(trans('项目成本控制'))
                        ->description(trans('新建材料类别'))
                        ->body($this->form());
        
    }

    /**
     * 项目材料类别
    */

    public function form(){
        $form = new Form(new MaterialCategory());
            
        $pids = MaterialCategory::getAllCategory($flag=1);

        $form->text('category_name',trans('材料名称'))->rules('required');
        $form->select('pid',trans('父级材料名称'))->options($pids);
        $form->tools(function (Form\Tools $tools){
            $tools->disableView();
        });
        
        $form->saving(function (Form $form){
            //新增、修改时判断数据是否存在
            $id = $form->model()->id;
            $insert_data = Input::all();
            $flag = false;

            $if_have = MaterialCategory::where('category_name','=',$insert_data['category_name'])
                                                ->where('pid','=',$insert_data['pid'])
                                                ->get(['id'])->toArray();
            if(count($if_have) != 0){
                if((!empty($id) && $id != $if_have[0]['id']) || (empty($id) && count($if_have[0]) != 0)){                        
                    $flag = true;
                }
            }
            if($flag){
                 throw new Exception(trans('该材料类别已存在'));
            }
        });
        return $form;
    }

    /**
     * 修改材料类别
     * @param $id
     */
    public function edit($id,Content $content){
        return $content->header(trans('项目成本控制'))
                        ->description(trans('修改材料类别'))
                        ->body($this->form()->edit($id));
    }
}
