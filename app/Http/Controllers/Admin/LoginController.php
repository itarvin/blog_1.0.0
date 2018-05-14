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

	public function login()
	{
		if($input = Input::all()){
			$result = (new User)->login($input);
			return response()->json($result);
        }
		return view('admin/login');
	}

	public function code()
	{
    	$code = new \Code;
    	$code->make();
    }
	
    public function getcode()
	{
    	$code = new \Code;
    	echo $code->get();
    }

    public function logout()
    {
        session(['user' => null]);
        return redirect('admin/login');
    }
}
