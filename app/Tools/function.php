<?php

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
