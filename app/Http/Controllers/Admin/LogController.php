<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class LogController extends BaseController
{
	/**
     * 应用场景：日志列表主页
     * @return view
     */
	public function index(Request $request)
	{
		$data = Log::orderBy('id','desc')->paginate(10);

		return view('admin/log/index',compact('data'));
	}
}
