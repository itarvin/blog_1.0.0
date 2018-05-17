<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Model\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
require_once 'resources/org/code/Code.class.php';
class LoginController extends Controller
{
	/**
     * 应用场景：登录操作
     * @return view
     */
	public function login()
	{
		if($input = Input::all()){
			$result = (new User)->login($input);
			return $result;
        }
		return view('admin/login');
	}

	/**
     * 应用场景：验证码输出
     * @return img
     */
	public function code()
	{
    	$code = new \Code;
    	$code->make();
    }

	/**
     * 应用场景：获取验证码
     * @return string
     */
    public function getcode()
	{
    	$code = new \Code;
    	echo $code->get();
    }

	/**
     * 应用场景：退出系统
     * @return view
     */
    public function logout()
    {
		session(['uid' => null]);
        session(['uanme' => null]);
        return redirect('admin/login');
    }
}
