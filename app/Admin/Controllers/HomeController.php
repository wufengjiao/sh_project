<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Layout\Content;


class HomeController extends Controller
{
    use ModelForm;
    /*
     * 网站后台首页
     */
    public function index(Content $content)
    {

        return view('home.index')->with(['header'=>trans('首页')]);
    }
}
