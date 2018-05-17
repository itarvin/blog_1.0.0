<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ProjectController extends BaseController
{
	/**
     * 应用场景：爬虫列表主页
     * @return view
     */
	public function index(Request $request)
	{
		$data = Project::orderBy('id','desc')->paginate(10);

		return view('admin/project/index',compact('data'));
	}
}
