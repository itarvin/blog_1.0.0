<?php
// 返回code参数
function returnCode($key)
{
	$code = [
		'SUCCESS' => 200,
		'ERROR'   => 400,
		'VALIDAERROR' => 421,
	];

	return $key ? $code[$key] : '500';
}

function makeIpInfo($clientIp)
{
	$url = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$clientIp;

	// 得到JSON数据
	$result = file_get_contents($url);

	// 使用函数解析JSON数据
	$result = json_decode($result,true);

	return $result['data'];
}

function checkManage($uid)
{
	$manage = ['1','2'];
	if(in_array($uid, $manage)){
		return true;
	}
	return false;
}
