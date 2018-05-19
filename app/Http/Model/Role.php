<?php
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;
class Role extends Model
{

    protected $table = 'role';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['rolename', 'remark'];

    protected $fillable = ['rolename', 'remark'];

    //表单验证规则
    public $rules = [
        'rolename' => 'required',
        'remark'   => 'required',
    ];

    //自定义消息显示
    protected $messages = [
        'rolename.required'    => '角色名称不能为空',
        'remark.required'      => '备注不能为空',
    ];

    /**
     * 应用场景：新增 || 修改
     * @return json
     */
    public function store($data)
    {

        $validator = Validator::make($data, $this->rules, $this->messages);

        if($data['pri_id']){
            $priIds = $data['pri_id'];
            unset($data['pri_id']);
        }else {
            return ['code' => returnCode("ERROR"), 'msg'=> '权限列表不能为空'];
        }
        if ($validator->passes()) {

            if(isset($data['id'])){

                if($this->where('id', $data['id'])->update($data)){

                    // 删除当前id所存在的权限
                    DB::table('role_pri')->where('role_id',$data['id'])->delete();

                    foreach ($priIds as $key => $value) {

                        DB::table('role_pri')->insert([
                            'pri_id' => $value,
        				    'role_id' => $data['id'],
                        ]);
                    }

                    return ['code' => returnCode("SUCCESS"), 'msg'=>'更新成功！'];
                }

            }else {

                if($role = $this->create($data)){

                    foreach ($priIds as $key => $value) {

                        DB::table('role_pri')->insert([
                            'pri_id' => $value,
        				    'role_id' => $role->id,
                        ]);
                    }
                    return ['code' => returnCode("SUCCESS"), 'msg'=>'添加成功！'];
                }
            }
            return ['code' => returnCode("ERROR"), 'msg'=>'操作失败！'];
        }else {

            return ['code' => returnCode("ERROR"), 'msg'=> $validator];
        }
    }

    /**
     * 应用场景：检测删除
     * @return json
     */
    public function checkDelete($rid)
    {
        if($rid){

            DB::table('role_pri')->where('role_id', $rid)->delete();

            if($this->where('id', $rid)->delete()){

                return ['code' => returnCode("SUCCESS"), 'msg'=>'操作成功！'];
            }else {

                return ['code' => returnCode("ERROR"), 'msg'=>'操作失败！'];
            }
        }
    }

    /**
     * 应用场景：搜索
     * @return json
     */
    public function search()
    {
        // 暂未找到有thinkphp 中那样使用GROUP_CONCAT() so 自定义处理拼装
        // $result['data'] = $this->join('role_pri', 'role.id', '=', 'role_pri.role_id')
        // ->join('privilege', 'privilege.id', '=', 'role_pri.pri_id')
        // ->select('role.*', 'privilege.pri_name as pri_name')
        // ->groupBy('role.id')
        // ->get();

        $result['data'] = $this->get();

        $pri_names = [];

        foreach ($result['data'] as $key => $value) {

            $pri_names = DB::table('role_pri')->where('role_id', $value['id'])
            ->join('privilege', 'privilege.id', '=', 'role_pri.pri_id')
            ->select('privilege.pri_name')
            ->get();

            $priname = dyadicArrayString($pri_names);
            $result['data'][$key]['pri_name'] = $priname;
        }

        $result['count'] = $this->count();

        return $result;
    }
}
