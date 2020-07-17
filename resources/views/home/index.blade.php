@extends('admin::index')
@section('content')
    <style>
        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }
        .position-ref {
            position: relative;
        }
        .full-height {
            height: 100vh;
        }
        .content {
            text-align: center;
        }
        .title {
            font-size: 20px;
        }
        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">
                欢迎登录 to do 此处建议存放日常入口文件
            </div>
        </div>
    </div>
@endsection
