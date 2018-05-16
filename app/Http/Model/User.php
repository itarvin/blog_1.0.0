<?php
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
require_once 'resources/org/code/Code.class.php';
class User extends Model
{
    //
    protected $table='admin';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['username', 'password','sex','phone','email','logo','think','createtime','lasttime','ip'];

    //表单验证规则
    public $rules = [
        'username' => 'required',
        'password' => 'required',
        'phone' => 'required',
        'email' => 'required',
    ];

    //自定义消息显示
    protected $messages = [
        'username.required' => '用户名不能为空',
        'password.required' => '密码不能为空',
        'phone.required'    => '电话不能为空',
        'email.required'    => '邮箱不能为空',
    ];

    /**
     * 应用场景：新增 || 修改
     * @return json
     */
    public function store($data)
    {
        $password = $data['password'] ? md5(md5($data['password'])) : '';

        if($password == ''){

            unset($data['password']);
        }else {
            
            $data['password'] = $password;
        }
        if(isset($data['id']) && empty($data['password'])){

            $oldpassword = $this->where('id', $data['id'])->first();

            $data['password'] = $oldpassword ? $oldpassword['password'] : '';
        }

        $validator = Validator::make($data, $this->rules, $this->messages);

        if ($validator->passes()) {

            if(isset($data['id'])){

                if($this->where('id', $data['id'])->update($data)){

                    return ['code' => returnCode("SUCCESS"), 'msg'=>'更新成功！'];
                }
            }else {

                $data['createtime'] = date('Y-m-d H:i:s',time());

                if($this->create($data)){

                    return ['code' => returnCode("SUCCESS"), 'msg'=>'添加成功！'];
                }
            }
            return ['code' => returnCode("ERROR"), 'msg'=>'操作失败！'];
        }else {

            return ['code' => returnCode("ERROR"), 'msg'=> $validator];
        }
    }

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

                return ['code' => returnCode("VALIDAERROR"), 'msg'=>'验证码错误'];
            }

            $user = $this->where('username', $data['username'])->first();

            if($user->username != $data['username'] || $user->password !=  md5(md5($data['password']))){

                return ['code' => returnCode("ERROR"), 'msg'=>'用户名或密码错误！'];
            }
            // 更新登录信息
            $lastInfo = ['lasttime' => date('Y-m-d H:i:s',time()), 'ip' => (new Request)->getClientIp()];

            $this->where('id', $user->id)->update($lastInfo);

            session(['uid' => $user->id, 'uname' => $user->username]);

            return ['code' => returnCode("SUCCESS"), 'msg'=>'认证成功！'];
        }else {
            return ['code' => returnCode("ERROR"), 'msg'=> $validator];
        }
    }
}
