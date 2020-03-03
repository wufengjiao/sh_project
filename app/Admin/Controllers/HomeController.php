<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Content;

class HomeController extends Controller
{
    /*
     * 项目预结算首页
     */
    public function index(Content $content)
    {
        return view('welcome');
    }
}
