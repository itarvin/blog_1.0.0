<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>后台登录-X-admin2.0</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="{{asset('/public/admin/css/font.css')}}">
	<link rel="stylesheet" href="{{asset('/public/admin/css/xadmin.css')}}">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{asset('/public/admin/lib/layui/layui.js')}}" charset="utf-8"></script>
    <script type="text/javascript" src="{{asset('/public/admin/js/xadmin.js')}}"></script>
</head>
<body class="login-bg">
    <div class="login">
        <div class="message">管理登录</div>
        <div id="darkbannerwrap"></div>
        <form method="post" class="layui-form" >
			<input name="username" placeholder="用户名"  type="text" lay-verify="required" class="layui-input" >
            <hr class="hr15">
            <input name="password" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15">
			<input name="verify" lay-verify="required" placeholder="验证码"  type="text" class="layui-input" style='width:150px; float:left;'>
			<img src="{{url('admin/code')}}" alt="captcha" onclick="refreshVerify()" id="verify_img" style='float:right;'>
            <hr class="hr15">
            <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
            <hr class="hr20" >
			{{csrf_field()}}
        </form>
    </div>
    <script>
	$(function  () {
		layui.use('form', function(){
			var form = layui.form;
			//监听提交
			form.on('submit(login)', function(data){
				//发异步，把数据提交给php
	            $.post("{{url('admin/login')}}",data.field,function(res){
	    			if(res.code == 200){
	                    layer.msg(res.msg, {time: 1000});
						location.href="{{url('admin/index')}}";
						// window.open("{{url('admin/index')}}","_blank");
	                }else{
	    				layer.msg(res.msg, {time: 2000});
	    			}
	            },'json');
                return false;
			});
		});
	})
	function refreshVerify(){
		var ts = Date.parse(new Date())/100;
		$('#verify_img').attr("src", "{{url('admin/code')}}?id="+ts);
	}
	// 解决完全退出页面
	if (window != top)
		top.location.href = location.href;
    </script>
</body>
</html>
