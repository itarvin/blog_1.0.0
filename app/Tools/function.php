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

// code对比
function codeChangeInfo()
{

}
