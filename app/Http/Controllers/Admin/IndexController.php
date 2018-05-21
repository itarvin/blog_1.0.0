<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Model\Rule;
class IndexController extends BaseController
{
	/**
     * 应用场景：后台导航
     * @return json
     */
	public function index()
	{
		$btns = (new Rule)->getBtns();
		return view('admin/index/index', compact('btns'));
	}

	/**
     * 应用场景：欢迎页
     * @return json
     */
	public function welcome()
	{
		return view('admin/index/welcome');
	}
}
