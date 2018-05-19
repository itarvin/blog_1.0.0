<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Model\Substance;
use App\Http\Model\Project;
use App\Http\Model\Music;
class ApiController extends Controller
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
	public function blog()
	{
		return (new Substance)->select('id','title','abstract','mid_picture','city','createtime','hits','authorid')->orderBy('id','desc')->get();
	}

	public function blogDetail($aid)
	{
		return (new Substance)->where('id', $aid)->get();
	}


	public function project()
	{
		$result = (new Project)->orderBy('id','desc')->paginate(100);
		foreach ($result as $key => $value) {
			preg_match_all('/[\x{4e00}-\x{9fff}]+/u', $value->company, $matches);
			$str = join('', $matches[0]);
			$data[$key]['company'] = $str;
			$data[$key]['addtime'] = substr($value->addtime,0,-9);
		}
		return $data;
	}


	public function music()
	{
		return (new Music)->orderBy('id','desc')->get();
	}
}
