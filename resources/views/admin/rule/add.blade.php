@extends('layouts.admin')
@section('content')
<div class="x-body">

    <form class="layui-form">
        <div class="layui-form-item">
            <label for="pri_name" class="layui-form-label">
                <span class="x-red">*</span>上级权限
            </label>
            <div class="layui-input-inline">
                <select name="parent_id" lay-verify="required" lay-search="">
                    <option value="0">顶级权限</option>
                    @foreach($rules as $k => $v)
                    <option value="{{$v['id']}}">{{str_repeat('-', 8*$v['level'])}}{{$v['pri_name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="pri_name" class="layui-form-label">
                <span class="x-red">*</span>权限名称
            </label>
            <div class="layui-input-inline">
                <input type="text" id="pri_name" name="pri_name" required="" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="module_name" class="layui-form-label">
                <span class="x-red">*</span>模块名称
            </label>
            <div class="layui-input-inline">
                <input type="text" id="module_name" name="module_name" required="" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="controller_name" class="layui-form-label">
                <span class="x-red">*</span>控制器名称
            </label>
            <div class="layui-input-inline">
                <input type="text" id="controller_name" name="controller_name" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="action_name" class="layui-form-label">
                <span class="x-red">*</span>方法名称
            </label>
            <div class="layui-input-inline">
                <input type="text" id="action_name" name="action_name" autocomplete="off" class="layui-input">
            </div>
        </div>
        {{csrf_field()}}

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
layui.use(['form','layer','upload'], function(){
    $ = layui.jquery;
    var form = layui.form
    ,layer = layui.layer;


    // 提交数据
    form.on('submit(add)', function(data){
        //发异步，把数据提交给php
        $.post("{{url('admin/rule')}}",data.field,function(res){

    		if(res.code == 200){
                layer.alert(res.msg, {icon: 6},function () {
                    // 获得frame索引
                    var index = parent.layer.getFrameIndex(window.name);
                    //关闭当前frame
                    parent.layer.close(index);
                });
            }else{
    			layer.msg(res.msg, {time: 2000});
    		}
        },'json');
        return false;
    });
});
</script>
@endsection
