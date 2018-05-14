<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\Substance;
use Illuminate\Http\Request;

// use App\Http\Requests;

class SubstanceController extends BaseController
{

    //
	public function index()
	{
		$data = DB::table('substance')
            ->orderBy('id','desc')->paginate(10);
		// dd($data);
		return view('admin/substance/index',compact('data'));
	}
	//
	public function store()
	{

	}
	//
	public function create()
	{
		return view('admin/substance/add');
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
