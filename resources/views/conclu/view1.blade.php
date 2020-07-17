@extends('admin::index')

@section('content')
    <section class="content-header">
        <h1>
            项目总结
            <small><?php echo $project['project_name'];?>/查看</small>
        </h1>
    </section>

    <section class="content">

        @include('admin::partials.alerts')
        @include('admin::partials.exception')
        @include('admin::partials.toastr')

        <div class="box attendace_view">
            <div class="box-header with-border">
                <div class="pull-right">
                    <div class="btn-group pull-right" style="margin-right: 10px">
                        <a href="/admin/attendance/{{$project['id']}}/create" class="btn btn-sm btn-success">
                            <i class="fa fa-save"></i>&nbsp;&nbsp;新增
                        </a>
                    </div>
                </div>
            <span>
                <a class="btn btn-sm btn-primary grid-refresh"><i class="fa fa-refresh"></i> 刷新</a>
                <div class="btn-group" style="margin-right: 10px" data-toggle="buttons">
                    <label class="btn btn-sm btn-dropbox 5dfb1c8bdb5ae-filter-btn screen-btn">
                        <input type="checkbox"><i class="fa fa-filter"></i>&nbsp;&nbsp;筛选
                    </label>
                </div>
            </span>
            </div>

            <div class="box-header with-border hide" id="filter-box">
                <form action="admin/attendance/55/view?_pjax=%23pjax-container" class="form-horizontal" pjax-container="" method="get">
                    <div class="box-body">
                        <div class="fields-group">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">日报时间</label>
                                <div class="col-sm-8" style="width: 390px">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control" id="create_at_start" placeholder="开始时间" name="create_at[start]" value="">
                                        <span class="input-group-addon" style="border-left: 0; border-right: 0;">-</span>
                                        <input type="text" class="form-control" id="create_at_end" placeholder="结束时间" name="create_at[end]" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <div class="btn-group pull-left">
                                <button class="btn btn-info submit"><i class="fa fa-search"></i>&nbsp;&nbsp;搜索</button>
                            </div>
                            <div class="btn-group pull-left " style="margin-left: 10px;">
                                <a href="http://www.sh_project.cn/admin/attendance/55/view" class="btn btn-default"><i class="fa fa-undo"></i>&nbsp;&nbsp;重置</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th> 序号 </th>
                        <th> 日报时间 </th>
                        <th> 日报内容 </th>
                        <th> 日报结果凭证 </th>
                        <th> 操作 </th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($attendances as $key => $data)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $data['create_at'] }}</td>
                            <td style="background-color: #99FFCC">{{ $data['daily_content'] }}</td>
                            <td>{{base_path($data['daili_content_pic']) }}}</td>
                            <td>
                                <a href="/admin/auth/attendance/{{$data['id']}}/attendanceView">编辑</a>
                                <a href="/admin/auth/attendance/{{$data['id']}}/delete">删除</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
@endsection

