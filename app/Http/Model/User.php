<?php
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
require_once 'resources/org/code/Code.class.php';
class User extends Model
{
    //
    protected $table='admin';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function login($data)
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',
            'verify' => 'required',
        ];
        $message =[
            'username.required' =>'用户名不能为空',
            'password.required' =>'用户密码不能为空',
            'verify.required'   =>'验证码不能为空',
        ];
        $validator = Validator::make($data,$rules,$message);

        if($validator->passes()){
            $code = new \Code;

            $_code = $code->get();

            if(strtoupper($data['verify']) != $_code){
                return ['code' => '421','msg'=>'验证码错误'];
            }

            $user = $this->where('username', $data['username'])->first();

            if($user->username != $data['username'] || $user->password !=  md5(md5($data['password']))){
                return ['code' => '400','msg'=>'用户名或密码错误！'];
            }
            session(['uid' => $user->id, 'uname' => $user->username]);

            return ['code' => '200','msg'=>'认证成功！'];
        }else {
            return ['code' => '400','msg'=> $validator];
        }
    }
}
