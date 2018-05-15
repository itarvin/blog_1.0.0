<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AdminController extends BaseController
{
	/**
     * 应用场景：列表主页 and 搜索
     * @return array
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
		$input = Input::except('_token');
		$input['logo'] = $this->upload($request);
		$result = (new User)->store($input);
		if($result){
			return back()->with('errors', $result['msg']);
		}
	}


	//
	public function create()
	{
		return view('admin/admin/add');
	}

	//
	public function show()
	{

	}

	//
	public function update($uid)
	{
		$input = Input::except('_token');
		// $request = new Request;
		// $input['logo'] = $this->upload($request);
		dd($input);
	}

	//
	public function edit($uid)
	{
		$data = User::find($uid);
        return view('admin.admin.edit',compact('data'));
	}
	//
	public function destroy()
	{

	}
}
