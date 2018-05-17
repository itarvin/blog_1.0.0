<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;

class CategoryController extends BaseController
{
	/**
     * 应用场景：分类列表
     * @return view
     */
	public function index()
	{
		$categorys = (new Category)->tree();
        return view('admin.category.index')->with('data',$categorys);
	}

	/**
     * 应用场景：添加执行
     * @return view
     */
	public function store()
	{

	}

	/**
     * 应用场景：添加页
     * @return view
     */
	public function create()
	{
		return view('admin/category/add');
	}

	public function show()
	{

	}

	/**
     * 应用场景：修改执行
     * @return json
     */
	public function update()
	{

	}

	/**
     * 应用场景：修改页
     * @return view
     */
	public function edit()
	{

	}

	/**
     * 应用场景：删除执行
     * @return json
     */
	public function destroy()
	{

	}
}
