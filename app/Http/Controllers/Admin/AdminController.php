<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AdminController extends BaseController
{
    //
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

	//
	public function store()
	{

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
