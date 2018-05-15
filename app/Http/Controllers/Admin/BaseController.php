<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
class BaseController extends Controller
{

	// //图片上传
    public function upload($request)
    {
		if($request->isMethod('POST')){	//判断是否是POST传值

			$file = $request->file('logo');
		    //文件是否上传成功
		    if($file->isValid()){	//判断文件是否上传成功

		        // $originalName = $file->getClientOriginalName(); //源文件名

		        $ext = $file->getClientOriginalExtension();    //文件拓展名

		        // $type = $file->getClientMimeType(); //文件类型

		        // $realPath = $file->getRealPath();   //临时文件的绝对路径

		        $fileName = date('YmdHis').uniqid().'.'.$ext;  //新文件名

		        $path = $file-> move(base_path().'/public/uploads/admin',$fileName);

		        $filepath = '/public/uploads/admin/'.$fileName;

		        return $filepath;
		    }
		}
    }
}
