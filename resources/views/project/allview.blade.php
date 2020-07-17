<!-- 根据模板content.blade.php来处理 -->
@extends('admin::index')

@section('content')
    <section class="content-header">
        <h1>
                项目预结算
            <small>项目总览</small>
        </h1>
    </section>

    <section class="content">

        @include('admin::partials.alerts')
        @include('admin::partials.exception')
        @include('admin::partials.toastr')
        <div class="row">
            <div class="col-md-12">
                <div class="project_allview box">
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th> 分类名称 </th>
                                    <th> 预算金额/(万) </th>
                                    <th> 已使用金额/(万) </th>
                                    <th> 使用进度百分比 </th>
                                    <th> 盈余/(万) </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($project_data as $data)
                                    <tr>
                                        <td>{{ $data[0] }}</td>
                                        <td>{{ $data[1] }}</td>
                                        <td style="background-color: #99FFCC">{{ $data[2] }}</td>
                                        <td>
                                            <div style="padding: 0; background-color: white; border: 1px solid navy; width: 100px">
                                                <div style="padding: 0; background-color: #FFCC66; width:<?php echo ($data[1]*$data[2]) / 100 ;?> px; height: 16px"></div>
                                            </div>
                                            <div style="position: relative; top: -18px; text-align: center; font-weight: bold; font-size: 10pt"><?php echo $data[2] / $data[1] * 100; ?>%</div>
                                        </td>
                                        <td class="<?php echo ($data[1] - $data[2]) > 0 ? "":"money_out_range";?>">{{ $data[1] - $data[2] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<script>

</script>




