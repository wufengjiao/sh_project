<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Documentation</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>




                <div style="margin:50px auto; padding: 8px; border: 1px solid gray; background: #EAEAEA;width: 16px;">

                    <div style="background-color: white; border: 1px solid navy; padding: 0px;width: 8px;">
                        <div id="progress" style="padding: 8px; background-color: #FFCC66; border: 0; width: 6px; ">

                        </div>
                    </div>
                    <div id="percent"
                         style="position: relative; top: -30px; text-align: center; font-weight: bold; font-size: 8pt">6%</div>
                </div>



                <div style="padding: 8px;">
                    <div style="padding: 0; background-color: white; border: 1px solid navy; width: 100px">
                        <div style="padding: 0; background-color: #FFCC66; border: 0; width:<?php echo ($data[1]*$data[2]) / 100 * 100 ;?> px; "></div>
                    </div>
                    <div style="position: relative; top: -30px; text-align: center; font-weight: bold; font-size: 8pt"><?php echo ($data[1]*$data[2]) / (10000) * 100; ?>%</div>
                </div>
            </div>
        </div>
    </body>
</html>
