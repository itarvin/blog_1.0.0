@extends('layouts.admin')
@section('content')
<div class="x-body">

    <form class="layui-form">

        <div class="layui-form-item">
            <label for="title" class="layui-form-label">
                <span class="x-red">*</span>标题
            </label>
            <div class="layui-input-inline">
                <input type="text" name="title" required="" lay-verify="required" value="{{$data->title}}" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="name" class="layui-form-label">
                <span class="x-red">*</span>名称
            </label>
            <div class="layui-input-inline">
                <input type="text" name="name" value="{{$data->name}}" required="" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="name" class="layui-form-label">
                <span class="x-red">*</span>排序
            </label>
            <div class="layui-input-inline">
                <input type="text" name="sort_num" required="" lay-verify="required" autocomplete="off" value="{{$data->sort_num}}" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="action_name" class="layui-form-label">
                <span class="x-red">*</span>类　　型：
            </label>
            <div class="layui-input-block">
                <input type="radio" name="field_type"  value="input" title="input"  lay-filter="type" @if($data->field_type == 'input') checked @endif>
                <input type="radio" name="field_type"  value="textarea" title="textarea" lay-filter="type" @if($data->field_type == 'textarea') checked @endif>
                <input type="radio" name="field_type" value="radio" title="radio" lay-filter="type" @if($data->field_type == 'radio') checked @endif>
            </div>
        </div>

          <div class="layui-form-item" id="field_value"  @if($data->field_type != 'radio') style="display:none;" @endif >
              <label for="action_name" class="layui-form-label">
                  <span class="x-red">*</span>类　型　值：
              </label>
              <div class="layui-input-inline">
                  <input type="text" name="field_value" value="{{$data->field_value}}" autocomplete="off" class="layui-input">该选项只有在Radio中使用！格式为：1|开启，0|关闭
              </div>
          </div>

          <div class="layui-form-item">
              <label for="controller_name" class="layui-form-label">
                  <span class="x-red">*</span>是否系统预留字段：
              </label>
              <div class="layui-input-inline">
                  <input type="checkbox" name="is_system" value="1" title="是" @if ($data->is_system == 1)checked @endif >
              </div>
          </div>

          {{csrf_field()}}
          <input type="hidden" name="_method" value="put">
          <input type="hidden" name="id" value="{{$data->id}}">
          <div class="layui-form-item">
              <label for="L_email" class="layui-form-label">
                  <span class="x-red">*</span>说明
              </label>
              <div class="layui-input-inline">
                  <textarea placeholder="请输入内容" class="layui-textarea" name="tips">{{$data->tips}}</textarea>
              </div>
          </div>

          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label>
              <button  class="layui-btn" lay-filter="add" lay-submit="">
                  更新
              </button>
          </div>

    </form>
</div>
<script>
layui.use(['form','layer','upload'], function(){
    $ = layui.jquery;
    var form = layui.form
    ,layer = layui.layer
    ,upload = layui.upload;

    // 提交数据
    form.on('submit(add)', function(data){
        //发异步，把数据提交给php
        $.post("{{url('admin/config/'.$data->id)}}",data.field,function(res){

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

    form.on('radio(type)', function(data){
        var type = data.value;
        if(type=='radio'){
            $('#field_value').show();
        }else if(type=='input'){
            $('#field_value').hide();
        }else if(type=="textarea"){
            $('#field_value').hide();
        }
    });
});
</script>
@endsection
