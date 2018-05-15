@extends('layouts.admin')
@section('content')
<div class="x-body">
    <form class="layui-form" enctype="multipart/form-data" action="{{url('admin/user/'.$data->id)}}" method="post">
        @if(count($errors)>0)
            <div class="layui-form-item">
                @if(is_object($errors))
                    @foreach($errors->all() as $error)
                        <span class="x-red">{{$error}}</span>
                    @endforeach
                @else
                    <span class="x-red">{{$errors}}</span>
                @endif
            </div>
        @endif
        <div class="layui-form-item">
            <label for="username" class="layui-form-label">
                <span class="x-red">*</span>登录名
            </label>
            <div class="layui-input-inline">
                <input type="text" id="username" name="username" value="{{$data->username}}" required="" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <input type="hidden" name="_method" value="put">
        {{csrf_field()}}
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
                <input type="text" id="phone" name="phone" required="" lay-verify="phone" value="{{$data->phone}}" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_email" class="layui-form-label">
                <span class="x-red">*</span>邮箱
            </label>
            <div class="layui-input-inline">
                <input type="text" id="L_email" name="email" required="" lay-verify="email" autocomplete="off" value="{{$data->email}}" class="layui-input">
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
              <textarea placeholder="请输入内容" class="layui-textarea" name="think">{{$data->think}}</textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_pass" class="layui-form-label">
                <span class="x-red">*</span>密码
            </label>
            <div class="layui-input-inline">
                <input type="password" id="L_pass" name="password" lay-verify="pass" autocomplete="off" class="layui-input">
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
                <input type="password" id="L_repass" lay-verify="repass" autocomplete="off" class="layui-input">
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
    });
});
</script>
@endsection
