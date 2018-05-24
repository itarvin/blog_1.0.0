<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Model\Substance;
use App\Http\Model\Project;
use App\Http\Model\News;
use App\Http\Model\Music;
use App\Http\Model\User;
use Illuminate\Support\Facades\Input;
class ApiController extends BaseController
{
	/**
     * 应用场景：后台导航
     * @return json
     */
	public function index()
	{
		return ['code' => '我以为你会回头！'];
	}

	/**
     * 应用场景：欢迎页
     * @return json
     */
	public function blog(Request $request)
	{
		$skip = $request->get("skip") ? $request->get("skip") : 0;
		$limit = $request->get("limit") ? $request->get("limit") : 2;
		$data = (new Substance)->select('id','title','abstract','picture','region','city','createtime','hits','authorid')->orderBy('id','desc')->take($limit)->skip($skip)->get();
		foreach ($data as $key => $value) {
			if($value->picture != ''){
				$data[$key]['picture'] = "http://".$_SERVER['HTTP_HOST'].$value->picture;
			}
		}
		return $data;
	}

	/**
     * 应用场景：博文详情
     * @return json
     */
	public function blogDetail($aid)
	{
		$data = (new Substance)->where('id', $aid)->get();
		foreach ($data as $key => $value) {
			if($value->picture != ''){
				$data[$key]['picture'] = "http://".$_SERVER['HTTP_HOST'].$value->picture;
			}
		}
		return $data;
	}

	/**
     * 应用场景：获取爬虫项目
     * @return json
     */
	public function project(Request $request)
	{
		$skip = $request->get("skip") ? $request->get("skip") : 0;
		$limit = $request->get("limit") ? $request->get("limit") : 2;
		$result = (new Project)->orderBy('id','desc')->take($limit)->skip($skip)->get();
		foreach ($result as $key => $value) {
			preg_match_all('/[\x{4e00}-\x{9fff}]+/u', $value->company, $matches);
			$str = join('', $matches[0]);
			$data[$key]['company'] = $str;
			$data[$key]['addtime'] = substr($value->addtime,0,-9);
		}
		return $data;
	}

	/**
     * 应用场景：获取音乐列表
     * @return json
     */
	public function music(Request $request)
	{
		$skip = $request->get("skip") ? $request->get("skip") : 0;
		$limit = $request->get("limit") ? $request->get("limit") : 2;
		$data = (new Music)->orderBy('id','desc')->take($limit)->skip($skip)->get();
		foreach ($data as $key => $value) {
			if($value->smallimg != ''){
				$data[$key]['smallimg'] = "http://".$_SERVER['HTTP_HOST'].$value->smallimg;
			}
		}
		return $data;
	}

	/**
     * 应用场景：获取音乐列表
     * @return json
     */
	public function user()
	{
		return (new User)->orderBy('id','desc')->get();
	}

	/**
     * 应用场景：获取最新动态
     * @return json
     */
	public function news(Request $request)
	{
		$skip = $request->get("skip") ? $request->get("skip") : 0;
		$limit = $request->get("limit") ? $request->get("limit") : 2;
		$data = (new News)->take($limit)->skip($skip)->orderBy('id','desc')->get();
		foreach ($data as $key => $value) {
			if($value->picture != ''){
				$data[$key]['picture'] = "http://".$_SERVER['HTTP_HOST'].$value->picture;
			}
		}
		return $data;
	}

	/**
     * 应用场景：获取最新动态详情
     * @return json
     */
	public function newsDetail($aid)
	{
		$data = (new News)->where('id', $aid)->get();
		foreach ($data as $key => $value) {
			if($value->picture != ''){
				$data[$key]['picture'] = "http://".$_SERVER['HTTP_HOST'].$value->picture;
			}
		}
		return $data;
	}

	/**
     * 应用场景：接口登录
     * @return json
     */
	public function login()
	{
		$input = Input::all();
		return (new User)->apiLogin($input);
	}
}
