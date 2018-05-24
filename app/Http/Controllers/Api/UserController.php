<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\User;
use App\Http\Model\Chat;
use Illuminate\Support\Facades\Input;
class UserController extends BaseController
{
	/**
     * 应用场景：获取我的朋友
     * @return json
     */
	public function getmyuser(Request $request)
	{
		$identity = $request->get("identity");
		if($return = $this->putInfo($identity) != true){
			return $return;
		}
		$skip = $request->get("skip") ? $request->get("skip") : 0;

		$limit = $request->get("limit") ? $request->get("limit") : 2;

		$data = (new User)->select('id','username','logo','lasttime','email')->take($limit)->skip($skip)->orderBy('id','desc')->get();

		$uid = $this->checkId($identity);

		foreach ($data as $key => $value) {
			if($value['id'] == $uid){
				unset($data[$key]);
			}else {
				if($value->logo != ''){

					$data[$key]['logo'] = "http://".$_SERVER['HTTP_HOST'].$value->logo;
				}
			}
		}
		return [
			'code' => returnCode("SUCCESS"),
			'msg'  => $data
		];

	}

	/**
     * 应用场景：进行聊天
     * @return json
     */
	public function interflow(Request $request)
	{
		$identity = $request->get("identity");
		if($return = $this->putInfo($identity) != true){
			return $return;
		}
		$data = Input::except('identity');
		return (new Chat)->store($data);
	}

	/**
     * 应用场景：拉取信息
     * @return json
     */
	public function pullMsg(Request $request)
	{
		$identity = $request->get("identity");
		if($return = $this->putInfo($identity) != true){
			return $return;
		}
		$data = Input::except('identity');
		return (new Chat)->pull($data);
	}
}
