<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\Music;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class MusicController extends BaseController
{

	/**
     * 应用场景：文章列表主页 and 搜索
     * @return view
     */
	public function index()
	{
		$data = Music::orderBy('id','desc')->paginate(10);
		return view('admin/music/index',compact('data'));
	}

	/**
     * 应用场景：添加执行
     * @return json
     */
	 public function store(Request $request)
 	{
 		$input = Input::except('_token','upfile');
 		return (new Music)->store($input);
 	}

	/**
     * 应用场景：添加页
     * @return view
     */
	public function create()
	{
		return view('admin/music/add');
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
		return (new Music)->store($input);
	}

	/**
     * 应用场景：更新页
     * @return view
     */
	public function edit($aid)
	{
		$data = Music::find($aid);
		return view('admin/music/edit',compact('data'));
	}

	/**
     * 应用场景：删除执行
     * @return json
     */
	public function destroy($aid)
	{
		return (new Music)->checkDelete($aid);
	}
}
