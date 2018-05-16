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
 		$input = Input::except('_token','picture');
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

	//
	public function update()
	{
		$input = Input::except('_token','_method','picture');
		return (new Substance)->store($input);
	}

	//
	public function edit($aid)
	{
		$data = Substance::find($aid);
		return view('admin/substance/edit',compact('data'));
	}

	//
	public function destroy($aid)
	{
		if(Substance::where('id', $aid)->delete()){
			$result = [
				'code' => returnCode("SUCCESS"),
				'msg'  => '请求成功！',
			];
		}else {
			$result = [
				'code' => returnCode("ERROR"),
				'msg'  => '请求失败了！',
			];
		}
		return $result;
	}
}
