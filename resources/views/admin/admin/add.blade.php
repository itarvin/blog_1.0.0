@extends('layouts.admin')
@section('content')
<div class="x-body">
    <form class="layui-form" enctype="multipart/form-data">
        <div class="layui-form-item">
            <label for="username" class="layui-form-label">
                <span class="x-red">*</span>登录名
            </label>
            <div class="layui-input-inline">
                <input type="text" id="username" name="username" required="" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">单选框</label>
            <div class="layui-input-block">
                <input type="radio" name="sex" value="男" title="男" checked="">
                <input type="radio" name="sex" value="女" title="女">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="phone" class="layui-form-label">
                <span class="x-red">*</span>手机
            </label>
            <div class="layui-input-inline">
                <input type="text" id="phone" name="phone" required="" lay-verify="phone" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_email" class="layui-form-label">
                <span class="x-red">*</span>邮箱
            </label>
            <div class="layui-input-inline">
                <input type="text" id="L_email" name="email" required="" lay-verify="email" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="x-red">*</span>头像</label>
            <div class="layui-upload-inline" >
                <input type="file" name="logo" class="layui-btn layui-btn-lg layui-btn-primary layui-btn-radius">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_email" class="layui-form-label">
                <span class="x-red">*</span>简介
            </label>
            <div class="layui-input-block">
              <textarea placeholder="请输入内容" class="layui-textarea" name="think"></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_pass" class="layui-form-label">
                <span class="x-red">*</span>密码
            </label>
            <div class="layui-input-inline">
                <input type="password" id="L_pass" name="password" required="" lay-verify="pass" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">
                6到16个字符
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
                <span class="x-red">*</span>确认密码
            </label>
            <div class="layui-input-inline">
                <input type="password" id="L_repass" name="repass" required="" lay-verify="repass" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
            </label>
            <button  class="layui-btn" lay-filter="add" lay-submit="">
                增加
            </button>
        </div>
    </form>
</div>
<script>
function extra_data(input,data){
	var item=[];
	$.each(data,function(k,v){
		item.push('<input type="hidden" name="'+k+'" value="'+v+'">');
	})
	$(input).after(item.join(''));
}

layui.use(['form','layer','upload'], function(){
    $ = layui.jquery;
    var form = layui.form
    ,layer = layui.layer
    ,upload = layui.upload;
    //拖拽上传
    // upload.render({
    //     elem: '#test10'
    //     ,url: '{{url("admin/upload")}}'
    //     ,data: {
    //         '_token' : "{{csrf_token()}}"
    //     }
    //     ,done: function(res){
    //         console.log(res)
    //     }
    // });

    //自定义验证规则
    form.verify({
        nikename: function(value){
            if(value.length < 5){
                return '昵称至少得5个字符啊';
            }
        }
        ,pass: [/(.+){6,12}$/, '密码必须6到12位']
        ,repass: function(value){
            if($('#L_pass').val()!=$('#L_repass').val()){
                return '两次密码不一致';
            }
        }
    });

    //监听提交
    form.on('submit(add)', function(data){
        console.log(data);
        //发异步，把数据提交给php
        layer.alert("增加成功", {icon: 6},function () {
            // 获得frame索引
            var index = parent.layer.getFrameIndex(window.name);
            //关闭当前frame
            parent.layer.close(index);
        });
        return false;
    });
});
</script>
@endsection
