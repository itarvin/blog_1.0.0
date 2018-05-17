<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;

class RuleController extends BaseController
{
	/**
     * 应用场景：权限列表
     * @return view
     */
	public function index()
	{
		$data = (new Rule)->getTree();
		$count = Rule::count();
		return view('admin/rule/index',compact('data','count'));
	}

	/**
     * 应用场景：添加执行
     * @return json
     */
	public function store()
	{
		$input = Input::except('_token');
 		return (new Rule)->store($input);
	}

	/**
     * 应用场景：添加页
     * @return view
     */
	public function create()
	{
		$rules = (new Rule)->getTree();
		return view('admin/rule/add',compact('rules'));
	}

	public function show()
	{

	}

	/**
     * 应用场景：更新执行
     * @return json
     */
	public function update($rid)
	{
		$input = Input::except('_token','_method');
		return (new Rule)->store($input);
	}

	/**
     * 应用场景：更新页
     * @return view
     */
	public function edit($rid)
	{
		$data = Rule::find($rid);
		$rules = (new Rule)->getTree();
		return view('admin/rule/edit',compact('data','rules'));
	}

	/**
     * 应用场景：删除执行
     * @return json
     */
	public function destroy($rid)
	{
		return (new Rule)->checkDelete($rid);
	}
}
