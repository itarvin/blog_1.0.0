<?php
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
class Substance extends Model
{
    //
    protected $table='substance';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded=[];

    protected $fillable = ['title', 'short_title','keywords','abstract','pictures','content','createtime','status','ip','country','region','city'];

    //表单验证规则
    public $rules = [
        // 'title' => 'required',
        // 'short_title' => 'required',
        // 'phone' => 'required',
        // 'email' => 'required',
    ];

    //自定义消息显示
    protected $messages = [
        // 'title.required' => '用户名不能为空',
        // 'short_title.required' => '密码不能为空',
        // 'phone.required'    => '电话不能为空',
        // 'email.required'    => '邮箱不能为空',
    ];

    /**
     * 应用场景：新增 || 修改
     * @return json
     */
    public function store($data)
    {
        // if(isset($data['id'])){
        //
        // }

        $validator = Validator::make($data, $this->rules, $this->messages);

        if ($validator->passes()) {

            if(isset($data['id'])){

                if($this->where('id', $data['id'])->update($data)){

                    return ['code' => returnCode("SUCCESS"), 'msg'=>'更新成功！'];
                }
            }else {

                $data['createtime'] = date('Y-m-d H:i:s',time());
                // 上线启用下面的一行
                // $ipInfo = makeIpInfo((new Request)->getClientIp());
                $ipInfo = makeIpInfo('223.74.180.50');
                $data['ip'] = $ipInfo['ip'];
                $data['country'] = $ipInfo['country'];
                $data['region'] = $ipInfo['region'];
                $data['city'] = $ipInfo['city'];

                if($this->create($data)){

                    return ['code' => returnCode("SUCCESS"), 'msg'=>'添加成功！'];
                }
            }
            return ['code' => returnCode("ERROR"), 'msg'=>'操作失败！'];
        }else {

            return ['code' => returnCode("ERROR"), 'msg'=> $validator];
        }
    }

}
