<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;

class CategoryController extends BaseController
{
    //
	public function index()
	{
		$categorys = (new Category)->tree();
        return view('admin.category.index')->with('data',$categorys);
	}
	//
	public function store()
	{

	}
	//
	public function create()
	{
		return view('admin/category/add');
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
