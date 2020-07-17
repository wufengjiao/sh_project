@extends('admin::index')

@section('content')
    <section class="content-header">
        <h1>
            项目成本控制
            <small>材料采购申请</small>
        </h1>
    </section>

    <section class="content">
        @include('admin::partials.alerts')
        @include('admin::partials.exception')
        @include('admin::partials.toastr')
        <div class="material_apply box">
            <div class="box-body table-responsive ">
                <form action="apply_store" method="post" class="form-horizontal" accept-charset="UTF-8"  pjax-container="">
                    <div class="box-body" style="margin-top: 0.7rem;">
                        <div class="tab-content fields-group">
                            <div class="form-group">
                                <label for="number" class="col-sm-2  control-label">采购编号:</label>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <input readonly="readonly"  type="text" id="number" class="form-control" value="{{$number}}"/>
                                    </div>
                                </div>
                                <label for="number" class="col-sm-2  control-label">使用项目:</label>
                                <div class="col-sm-4">
                                    <select class="form-control project" id="project">
                                        @if(!empty($projects))
                                            @foreach($projects as $project)
                                                <option value="{{$project['id']}}">{{$project['project_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="number" class="col-sm-2  control-label">采购标题:</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" id="title" name="title" class="form-control" value="" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="number" class="col-sm-2  control-label">采购备注:</label>
                                <div class="col-sm-4">
                                    <textarea name="remark" id="remark" class="form-control remark" rows="2"></textarea>
                                </div>
                            </div>
                            <div class="form-group box-body table-responsive">
                                {{--清单头部--}}
                                <div class="box-header with-border apply-form">
                                    <div class="apply-form1">
                                        <label for="procurement">采购清单</label>
                                        <!-- <div class="btn-group pull-right" style="padding-right: 10px;">
                                            <input type="button" class="btn btn-sm btn-success apply-btn" value="删除条目">
                                        </div> -->
                                        <div class="btn-group pull-right" style="padding-right: 20px;">
                                            <input type="button" class="btn btn-sm btn-success apply-btn" value="新增条目">
                                        </div>
                                    </div>
                                </div>
                                {{--清单表格正文--}}
                                <div>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <td>序号</td>
                                                <td>材料类别</td>
                                                <td>购入单价/(元)</td>
                                                <td>购入数量</td>
                                                <td>市场最低价</td>
                                                <td>购入总额/(元)</td>
                                                <td>操作</td>

                                            </tr>
                                        </thead>
                                        <tbody id="table-container" style="display: none">
                                        </tbody>
                                        <tfoot>
                                            {{--尾部--}}
                                            <tr id="table-tail">
                                                <td colspan="7">
                                                    <label for="caution" style="display:block;float:left;color: red">总材料成本使用进度条:
                                                        <span id="progress_percent">0</span>%
                                                    </label>
                                                    <div id="white-progress">
                                                        <div id="progress">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
{{--                            审批材料采购页面--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="number" class="col-sm-2  control-label">打款凭证:</label>--}}
{{--                                <div class="col-sm-8">--}}
{{--                                    <input type="file" multiple="multiple" id="upload_money_images" name="upload_money_images[]">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="number" class="col-sm-2  control-label">采购凭证:</label>--}}
{{--                                <div class="col-sm-8">--}}
{{--                                    <input type="file" multiple="multiple" id="upload_procurement_images" name="upload_procurement_images[]">--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="form-group">
                                <div class="col-sm-4"></div>
                                <div class="btn-group col-sm-4">
                                    <button type="reset" class="btn btn-warning">重置</button>
                                </div>
                                <div class="btn-group col-sm-4">
                                    <button type="submit" class="btn btn-primary">提交</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="table-container-content" class="table-container-content" >
            <table>
                <tr id="row0">
                    <td class="index" id="index">1</td>
                    <td class="category" id="category">
                        <select class="form-control" onchange="changeLowprice(this)">
                            @if(!empty($category))
                                @foreach($category as $cat)
                                    <option
                                        value="{{$cat['id']}}">{{$cat['category_name']}}</option>
                                @endforeach
                            @endif
                        </select>
                    </td>
                    <td class="market_price" id="market_price" >
                        <input type="text" value="" style="width: auto;text-align: center;border: none;">
                    </td>
                    <td class="number" id="number">
                        <input type="text"  value="" style="width: auto;text-align: center;border: none;">
                    </td>
                    <td class="low_market" id="low_market">0</td>
                    <td class="sum" id="sum">0</td>
                    <td>
                        <a href="javascript:void(0);" data-id="312" class="grid-row-delete">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
            </table>

        </div>
    </section>
@endsection
