<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class RoleController extends BaseController
{
    //
	public function index()
	{
		return view('admin/role/index');
	}
	//
	public function store()
	{

	}
	//
	public function create()
	{
		return view('admin/role/add');
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
