<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class NewsController extends BaseController
{
    //
	public function index()
	{
		$data = User::orderBy('id','desc')->paginate(10);
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