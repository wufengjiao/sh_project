@extends('admin::index')

@section('content')
    <section class="content-header">
        <h1>
            项目总结
            <small><?php echo $project['project_name']?>/新建评价</small>
        </h1>
    </section>

    <section class="content">

        @include('admin::partials.alerts')
        @include('admin::partials.exception')
        @include('admin::partials.toastr')

        <div class="box conslu_create">

        </div>
    </section>
@endsection
