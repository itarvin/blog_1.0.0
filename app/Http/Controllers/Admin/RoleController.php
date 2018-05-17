<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\Role;
use App\Http\Model\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;

use App\Http\Requests;

class RoleController extends BaseController
{
	/**
     * 应用场景：角色列表
     * @return view
     */
	public function index()
	{
		$result = (new Role)->search();
		$data = $result['data'];
		$count = $result['count'];
		return view('admin/role/index', compact('data','count'));
	}

	/**
     * 应用场景：添加执行
     * @return json
     */
	public function store()
	{
		$input = Input::except('_token');
 		return (new Role)->store($input);
	}

	/**
     * 应用场景：添加页
     * @return view
     */
	public function create()
	{
		$priData = (new Rule)->getTree();
		return view('admin/role/add',compact('priData'));
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

		return (new Role)->store($input);
	}

	/**
     * 应用场景：更新页
     * @return view
     */
	public function edit($rid)
	{
		$data = Role::find($rid);

		$priData = (new Rule)->getTree();

        $rpData = DB::table('role_pri')
        ->where('role_id', $rid)
		->lists('pri_id');
		
		return view('admin/role/edit',compact('data','priData','rpData'));
	}

	/**
     * 应用场景：删除执行
     * @return json
     */
	public function destroy($rid)
	{
		return (new Role)->checkDelete($rid);
	}
}
