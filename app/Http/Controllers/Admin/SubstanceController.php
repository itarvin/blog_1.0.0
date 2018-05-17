<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\Substance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

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
	 public function store(Request $request)
 	{
 		$input = Input::except('_token','upfile');
 		return (new Substance)->store($input);
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

	/**
     * 应用场景：更新执行
     * @return json
     */
	public function update()
	{
		$input = Input::except('_token','_method','upfile');
		return (new Substance)->store($input);
	}

	/**
     * 应用场景：更新页
     * @return view
     */
	public function edit($aid)
	{
		$data = Substance::find($aid);
		return view('admin/substance/edit',compact('data'));
	}

	/**
     * 应用场景：删除执行
     * @return json
     */
	public function destroy($aid)
	{
		return (new Substance)->checkDelete($aid);
	}
}
