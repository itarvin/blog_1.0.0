<?php

function getRequestInfo()
{
	$actions = explode('\\', \Route::current()->getActionName());

	//或$actions=explode('\\', \Route::currentRouteAction());
	$modelName = $actions[count($actions)-2]=='Controllers'?null:$actions[count($actions)-2];

	$func = explode('@', $actions[count($actions)-1]);

	$controllerName = $func[0];
	$actionName = $func[1];

	$result['mudule'] = $modelName;
	$result['controller'] = substr($controllerName,0,-10);
	$result['action'] = $actionName;
	
	return $result;
}
/*
*msubstr($str, $start=0, $length, $charset=”utf-8″, $suffix=true)
*$str:要截取的字符串
*$start=0：开始位置，默认从0开始
*$length：截取长度
*$charset=”utf-8″：字符编码，默认UTF－8
*$suffix=true：是否在截取后的字符后面显示省略号，默认true显示，false为不显示
*模版使用：{{$vo->title|msubstr=0,5,'utf-8',false}}
*/
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true)
{
	if(function_exists("mb_substr")){

		if($suffix)
			return mb_substr($str, $start, $length, $charset)."...";
        else
			return mb_substr($str, $start, $length, $charset);
	}elseif(function_exists('iconv_substr')){

		if($suffix)
			return iconv_substr($str,$start,$length,$charset)."...";
		else
			return iconv_substr($str,$start,$length,$charset);
	}
	$re['utf-8']   = "/[x01-x7f]|[xc2-xdf][x80-xbf]|[xe0-xef][x80-xbf]{2}|[xf0-xff][x80-xbf]{3}/";

    $re['gb2312'] = "/[x01-x7f]|[xb0-xf7][xa0-xfe]/";

    $re['gbk']    = "/[x01-x7f]|[x81-xfe][x40-xfe]/";

    $re['big5']   = "/[x01-x7f]|[x81-xfe]([x40-x7e]|xa1-xfe])/";

    preg_match_all($re[$charset], $str, $match);

    $slice = join("",array_slice($match[0], $start, $length));

    if($suffix) return $slice."…";
		return $slice;
}

/**
 * 应用场景：二维数组转字符串
 * @return string
 */
function dyadicArrayString($data){

	$result = '';

	foreach ($data as $key => $value) {

		foreach ($value as $k2 => $v2) {

			$result .= $v2.",";
		}
	}
	return $result;
}


/**
 * 应用场景：返回code参数
 * @return int
 */
function returnCode($key)
{
	$code = [
		'SUCCESS' => 200,
		'ERROR'   => 400,
		'VALIDAERROR' => 421,
	];

	return $key ? $code[$key] : '500';
}

/**
 * 应用场景：获取客户端信息
 * @return json
 */
function makeIpInfo($clientIp)
{
	$url = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$clientIp;

	$result = file_get_contents($url);

	$result = json_decode($result,true);

	return $result['data'];
}

/**
 * 应用场景：检测系统管理员
 * @return Boole
 */
function checkManage($uid)
{
	$manage = ['1','2'];
	if(in_array($uid, $manage)){
		return true;
	}
	return false;
}

/**
 * 应用场景：日志记录获取
 * @return array
 */
function getIpInfo($clientIp)
{
	$url = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$clientIp;

    $result = file_get_contents($url);

    $result = json_decode($result,true);

	if($result['code']!==0 || !is_array($result['data'])) return false;

	$ret = [];

	foreach($result[data] as $k =>$v){

        if(gettype($v) == 'array' || gettype($v) == 'object'){

            $ret[$k] = objtoarr($v);
        }else{

          $ret[$k] = $v;
        }
	}
    return $ret;
}
