<?php
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Model\User;
use Agent;
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


    /**
     * 应用场景：登录验证
     * @return json
     */
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
            // $lastInfo = ['lasttime' => date('Y-m-d H:i:s',time()), 'ip' => (new Request)->getClientIp()];
            $lastInfo = ['lasttime' => date('Y-m-d H:i:s',time()), 'ip' => '127.0.0.1'];

            $this->where('id', $user->id)->update($lastInfo);

            session(['uid' => $user->id]);

            session(['uname' => $user->username]);
            // 日志写入
            (new Log)->takeNotes();

            return ['code' => returnCode("SUCCESS"), 'msg'=>'认证成功！'];

        }else {
            return ['code' => returnCode("ERROR"), 'msg'=> $validator];
        }
    }

    public function apiLogin($data)
    {
        $browser = Agent::browser();
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        $message =[
            'username.required' =>'用户名不能为空',
            'password.required' =>'用户密码不能为空',
        ];

        $validator = Validator::make($data,$rules,$message);

        if($validator->passes()){

            $user = $this->where('username', $data['username'])->first();
            if($user != null){
                if($user->password !=  md5(md5($data['password']))){

                    return ['code' => returnCode("ERROR"), 'msg'=>'用户名或密码错误！'];
                }

                // 加密账户密码
                $salt = md5($user->users.$user->password);
                // 对数据二次加密
                $token = $this->encryption($user->id, $browser, $salt);

                return ['code' => returnCode("SUCCESS"), 'msg'=>'认证成功！','identity' => $token];
            }else {
                return ['code' => returnCode("ERROR"), 'msg'=>'用户名或密码错误！'];
            }
        }else {
            return ['code' => returnCode("ERROR"), 'msg'=> $validator];
        }
    }


    /**
     * base64二次加密处理
     * @return string
     */
    private function encryption($userid,$agent,$salt)
    {
        // 密码薄
        $passwordBook = makeRandom();
        // 加密UID
        $uid = base64_encode(json_encode($userid));
        $tokens = array(
            'agent' => $agent,
            'salt' => $salt
        );
        // 转为base64
        $key = base64_encode(json_encode($tokens));
        // 计算秘钥长度和用户id长度
        $secretLen = strlen($key);
        $uLen = strlen($uid);
        $random = rand(0,25);
        // 生成随机数
        $start = $passwordBook[$random];
        $end = $passwordBook[$uLen];
        // 分隔字符串
        $tokenStart = mb_substr($key, 0, ($secretLen/2), 'utf-8');
        $uidStart = mb_substr($tokenStart, 0, $random, 'utf-8');
        $uidEnd = mb_substr($tokenStart, $random, strlen($tokenStart), 'utf-8');
        // 生成md5一个介质
        $medium = md5('itarvin'.time());
        // 结束后半部
        $tokenEnd = mb_substr($key,($secretLen/2),$secretLen, 'utf-8');
        // 拼装加密新字符串
        $token = $start.$uidStart.$uid.$uidEnd.$medium.$tokenEnd.$end;
        return $token;
    }
}
