<?php
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;
class Rule extends Model
{
    //
    protected $table='privilege';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded=[];

    protected $fillable = ['pri_name', 'module_name','controller_name','action_name','parent_id'];

    //表单验证规则
    public $rules = [
        'pri_name' => 'required',
        'module_name' => 'required',
    ];

    //自定义消息显示
    protected $messages = [
        'pri_name.required'    => '权限名称不能为空',
        'module_name.required' => '模块名称不能为空',
    ];

    /**
     * 应用场景：新增 || 修改
     * @return json
     */
    public function store($data)
    {

        $validator = Validator::make($data, $this->rules, $this->messages);

        if ($validator->passes()) {

            if(isset($data['id'])){

                if($this->where('id', $data['id'])->update($data)){

                    return ['code' => returnCode("SUCCESS"), 'msg'=>'更新成功！'];
                }
            }else {

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
     * 应用场景：检测删除
     * @return json
     */
    public function checkDelete($rid)
    {
        if($this->getChildren($rid)){

            return ['code' => returnCode("ERROR"), 'msg'=>'存在下级数据,禁止操作！'];
        }else {

            if($this->where('id', $rid)->delete()){

                return ['code' => returnCode("SUCCESS"), 'msg'=>'操作成功！'];
            }else{

                return ['code' => returnCode("ERROR"), 'msg'=>'操作失败！'];
            }
        }
    }

    /**
     * 应用场景：调取树状数组
     * @return json
     */
	public function getTree()
	{
		$data = $this->all();

		return $this->_reSort($data);
	}

    /**
     * 应用场景：回调级别排序
     * @return json
     */
	private function _reSort($data, $parent_id=0, $level=0, $isClear=TRUE)
	{

		static $ret = [];

		if($isClear)
			$ret = [];

		foreach ($data as $k => $v)
		{

			if($v['parent_id'] == $parent_id)
			{

				$v['level'] = $level;

				$ret[] = $v;

				$this->_reSort($data, $v['id'], $level+1, FALSE);
			}
		}

		return $ret;
	}

    /**
     * 应用场景：获取子分类
     * @return json
     */
    public function getChildren($id)
    {
        // 取出数据表的所有数据
        $data = $this->all();
        // 回调下一个方法，并传参数
        return $this->_children($data, $id);
    }

    /**
     * 应用场景：回调子类数据
     * @return json
     */
    private function _children($data, $parent_id=0, $isClear=TRUE)
    {

        static $ret = [];

        if($isClear)
            $ret = [];
        // 循环所有的数据
        foreach ($data as $k => $v)
        {
            // 若父级ID为参数所给的值
            if($v['parent_id'] == $parent_id)
            {
                // 把键给一维数组
                $ret[] = $v['id'];
                // 回调本身，循环取出所有的子类
                $this->_children($data, $v['id'], FALSE);
            }
        }
        // 返回一维数组
        return $ret;
    }


    /**
	 * 检查当前管理员是否有权限访问这个页面,
     * @return int
	 */
	public function checkPri()
	{
		// 获取当前管理员正要访问的模型名称、控制器名称、方法名称
		$adminId = session('uid');

		// 如果是超级管理员直接返回 TRUE
		if(checkManage($adminId))
			return TRUE;
        $request = getRequestInfo();

        $has = DB::table('admin_role')
        ->join('role_pri', 'role_pri.role_id', '=', 'admin_role.role_id')
        ->join('privilege', 'privilege.id', '=', 'role_pri.pri_id')
        ->where([
            ['admin_role.admin_id', '=',$adminId],
            ['admin_role.module_name', '=',$request['module']],
            ['admin_role.controller_name', '=',$request['controller']],
            ['admin_role.action_name', '=',$request['action']],
        ])->count();

		return ($has > 0);
	}


	/**
	 * 获取当前管理员所拥有的前两级的权限
	 * @return array
	 */
	public function getBtns()
	{

		$adminId = session('uid');

		if(checkManage($adminId)){

			$priData = $this->get();
		}else{

			// 取出当前管理员所在角色 所拥有的权限
            $priData = DB::table('admin_role')->select('privilege.*')
            ->join('role_pri', 'role_pri.role_id', '=', 'admin_role.role_id')
            ->join('privilege', 'privilege.id', '=', 'role_pri.pri_id')
            ->where('admin_role.admin_id', $adminId)
            ->get();
		}
        $ar = [];
        foreach ($priData as $key => $value) {
            $ar['id']                = $value->id;
            $ar['pri_name']          = $value->pri_name;
            $ar['module_name']       = $value->module_name;
            $ar['controller_name']   = $value->controller_name;
            $ar['action_name']       = $value->action_name;
            $ar['parent_id']         = $value->parent_id;
            $pd[] = $ar;
        }

		$btns = [];

		foreach ($pd as $k => $v){

			if($v['parent_id'] == 0){

				foreach ($pd as $k1 => $v1){

					if($v1['parent_id'] == $v['id'] ){

						$v['children'][] = $v1;
					}
				}
				$btns[] = $v;
			}
		}
		return $btns;
	}
}
