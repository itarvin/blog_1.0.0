<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
class BaseController extends Controller
{

	//图片上传
    public function upload(Request $request)
    {
		if($request->isMethod('POST')){	//判断是否是POST传值

            $field = $request->input('name');

			$file = $request->file('picture');
			if($file == null){
				return ['code' => returnCode("ERROR"), 'msg' => '上传失败！'];
			}
		    //文件是否上传成功
		    if($file->isValid()){	//判断文件是否上传成功

		        $ext = $file->getClientOriginalExtension();    //文件拓展名

		        $fileName = date('YmdHis').uniqid().'.'.$ext;  //新文件名

		        $path = $file-> move(base_path().'/public/uploads/'.$field,$fileName);

		        $filepath = '/public/uploads/'.$field.'/'.$fileName;

                return ['code' => returnCode("SUCCESS"), 'msg' => $filepath];
		    }else {
                return ['code' => returnCode("ERROR"), 'msg' => '上传失败！'];
            }
		}
    }

}
