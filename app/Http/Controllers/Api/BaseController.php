<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Model\User;
use Agent;
class BaseController extends Controller
{
	/**
     * 应用场景：获取id
     * @return int
     */
	protected function checkId($identity)
	{
		$result = $this->analysisCode($identity);
		$uid = json_decode(base64_decode($result['uid']));
		return $uid;
	}


	/**
     * 应用场景：判断存在权限获取
     * @return bool
     */
	protected function putInfo($identity)
	{
		if($identity == '' || !$this->checkLogin($identity)){
			return [
				'code' => returnCode("ERROR"),
				'msg'  => "请登录您的账号！"
			];
		}else {
			return true;
		}
	}

	/**
     * 应用场景：检测登录信息
     * @return view
     */
	protected function checkLogin($identity)
	{
		// 获取客户端设备
		$agent =  Agent::browser();
		// 析出用户id和客户信息
		$result = $this->analysisCode($identity);
		// 解析token验证
		$key = json_decode(base64_decode($result['token'], true), true);

		$uid = json_decode(base64_decode($result['uid']));

		$preview = User::find($uid);

		// 验证是否当前用户设备与提交的用户设备一致.
		if( $key['agent'] == $agent && md5($preview->username.$preview->password) == $key['salt']){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * base64二次加密数据进行析出
	 * @return array
	 */
	private function analysisCode($token)
	{
		// 析出当前数据对比验证
		$passwordBook = makeRandom();
		// 分离关键字母
		$begin = substr($token,0,1);
		$finish = substr($token,-1);
		$middles = substr($token,1,-1);
		// 定位出UID位置以及单位长度
		$beginKey = array_search($begin,$passwordBook);
		$finishKey = array_search($finish,$passwordBook);
		// 析出用户id
		$uidkey = substr($middles,$beginKey,$finishKey);
		// 合并剩下的字符串
		$all = substr($middles,0,$beginKey).substr($middles,($beginKey+$finishKey));
		// 计算长度
		$allLen = strlen($all);
		// 取出32位介质分离出tokeb前半部和后半部
		$reTokenStart = mb_substr($all, 0, (($allLen-32)/2), 'utf-8');
		$reTokenEnd = mb_substr($all, (($allLen-32)/2) + 32);
		// 合并数据返回
		$result = $reTokenStart.$reTokenEnd;
		return array(
			'uid'   => $uidkey,
			'token' => $result
		);
	}
}
