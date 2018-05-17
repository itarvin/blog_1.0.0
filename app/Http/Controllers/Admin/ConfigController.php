<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ConfigController extends BaseController
{
	/**
     * 应用场景：列表主页 and 搜索
     * @return view
     */
	public function index()
	{
		$result = (new Config)->search();
		$data = $result['data'];
		$count = $result['count'];
		return view('admin/config/index',compact('data','count'));
	}

	/**
     * 应用场景：执行添加
     * @return json
     */
	public function store()
	{
		$input = Input::except('_token');
		return (new Config)->store($input);
	}

	/**
     * 应用场景：创建页
     * @return view
     */
	public function create()
	{
		return view('admin/config/add');
	}

	public function show()
	{

	}

	/**
     * 应用场景：更新方法
     * @return json
     */
	public function update($uid)
	{
		$input = Input::except('_token','_method');
		return (new Config)->store($input);
	}

	/**
     * 应用场景：修改页
     * @return view
     */
	public function edit($uid)
	{
		$data = Config::find($uid);
        return view('admin.config.edit',compact('data'));
	}


	/**
     * 应用场景：删除执行
     * @return json
     */
	public function destroy($cid)
	{
		return (new Config)->checkDelete($cid);
	}

	/**
     * 应用场景：批量更新配置全部内容
     * @return json
     */
	public function updateContent(Request $request)
	{
		if($request->isMethod('post')){
			$tmp = Input::except('_token','_method');
            // 重新拼数组然后循环提交信息
            foreach($tmp['id'] as $k => $v){
                $data[$k]['id'] = $v;
            }
            foreach($tmp['content'] as $k => $v){
                $data[$k]['content'] = $v;
            }
            foreach($tmp['sort_num'] as $k => $v){
                $data[$k]['sort_num'] = $v;
            }
            foreach($data as $v){
                (new Config)->where('id', $v['id'])->update($v);
            }
            return ['code' => returnCode("SUCCESS"), 'msg'=>'更新成功！'];
		}
	}
}
