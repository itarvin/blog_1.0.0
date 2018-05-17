<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AdminController extends BaseController
{
	/**
     * 应用场景：列表主页 and 搜索
     * @return view
     */
	public function index(Request $request)
	{
		$data = User::orderBy('id','asc')->paginate(10);

		if ($request->isMethod('POST')){
			$input = Input::all();

			$where = [];

			if($input['start'] && $input['end']){

				$where[] = ['createtime', '>', $input['start']];
				$where[] = ['createtime', '<', $input['end']];
			}elseif($input['start']) {

				$where[] = ['createtime', '>', $input['start']];
			}elseif($input['end']) {

				$where[] = ['createtime', '<', $input['end']];
			}
			if($input['username']){
				$where[] = ['username', $input['username']];
			}

	    	$data = User::where($where)->paginate(10);
		}

		return view('admin/admin/index',compact('data'));
	}

	/**
     * 应用场景：执行添加
     * @return array
     */
	public function store(Request $request)
	{
		$input = Input::except('_token','upfile');
		return (new User)->store($input);
	}


	/**
     * 应用场景：创建页
     * @return view
     */
	public function create()
	{
		return view('admin/admin/add');
	}

	//
	public function show()
	{

	}

	/**
     * 应用场景：更新方法
     * @return json
     */
	public function update($uid)
	{
		$input = Input::except('_token','_method','upfile');
		return (new User)->store($input);
	}

	/**
     * 应用场景：修改页
     * @return view
     */
	public function edit($uid)
	{
		$data = User::find($uid);
        return view('admin.admin.edit',compact('data'));
	}


	/**
     * 应用场景：删除页
     * @return json
     */
	public function destroy($uid)
	{
		if(User::where('id', $uid)->delete()){
			return [
				'code' => returnCode("SUCCESS"),
				'msg'  => '请求成功！',
			];
		}else {
			return [
				'code' => returnCode("ERROR"),
				'msg'  => '请求失败了！',
			];
		}
	}


	/**
     * 应用场景：批量删除
     * @return json
     */
	public function delall()
	{
		$input = Input::except('_token');
		$success = [];
		$authority = [];
		foreach ($input['data'] as $key => $user) {

			if(checkManage($user)){

				$authority[] = $user;
			}else {

				if(User::where('id', $user)->delete()){

					$success[] = $user;
				}else {

					$authority[] = $user;
				}
			}
		}
		return  ['code' => returnCode("SUCCESS"), 'msg' => "执行成功".count($success).'条!失败'.count($authority)."条！"];
	}

	/**
     * 应用场景：修改状态
     * @return json
     */
	public function changeStatus()
	{
		$input = Input::except('_token')['data'];

		$value = $input['status'] == 1 ? '0' : '1';

		if(User::where('id',$input['uid'])->update(['user_status' => $value])){

			return [
				'code' => returnCode("SUCCESS"),
				'msg'  => '请求成功！',
			];
		}else {

			return [
				'code' => returnCode("ERROR"),
				'msg'  => '请求失败了！',
			];
		}
	}
}
