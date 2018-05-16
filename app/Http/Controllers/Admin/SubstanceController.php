<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\Substance;
use Illuminate\Http\Request;

// use App\Http\Requests;

class SubstanceController extends BaseController
{

	/**
     * 应用场景：文章列表主页 and 搜索
     * @return view
     */
	public function index()
	{
		$data = Substance::orderBy('id','desc')->paginate(10);
		return view('admin/substance/index',compact('data'));
	}

	/**
     * 应用场景：添加执行
     * @return json
     */
	public function store()
	{

	}

	/**
     * 应用场景：添加页
     * @return view
     */
	public function create()
	{
		return view('admin/substance/add');
	}

	//
	public function show()
	{

	}

	//
	public function update()
	{

	}

	//
	public function edit()
	{

	}

	//
	public function destroy()
	{

	}
}
