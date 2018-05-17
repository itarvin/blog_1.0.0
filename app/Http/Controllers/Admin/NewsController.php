<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;

class NewsController extends BaseController
{
	/**
     * 应用场景：图库列表页
     * @return view
     */
	public function index()
	{
		$data = News::orderBy('id','desc')->paginate(10);
		return view('admin/news/index',compact('data'));
	}

	/**
     * 应用场景：添加执行
     * @return json
     */
	public function store()
	{
		$input = Input::except('_token','upfile');
		return (new News)->store($input);
	}

	/**
     * 应用场景：添加页
     * @return view
     */
	public function create()
	{
		return view('admin/news/add');
	}


	public function show()
	{

	}

	/**
     * 应用场景：更新执行
     * @return json
     */
	public function update($nid)
	{
		$input = Input::except('_token','_method','upfile');
		return (new News)->store($input);
	}

	/**
     * 应用场景：更新页
     * @return view
     */
	public function edit($nid)
	{
		$data = News::find($nid);
		return view('admin/news/edit',compact('data'));
	}

	/**
     * 应用场景：删除执行
     * @return json
     */
	public function destroy($nid)
	{
		return (new News)->checkDelete($nid);
	}
}
