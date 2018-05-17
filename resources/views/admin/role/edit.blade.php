@extends('layouts.admin')
@section('content')
    <div class="x-body">
        <form class="layui-form layui-form-pane">

                <div class="layui-form-item">
                    <label for="rolename" class="layui-form-label">
                        <span class="x-red">*</span>角色名
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="rolename" name="rolename" required="" lay-verify="required"
                        autocomplete="off" class="layui-input" value="{{$data->rolename}}">
                    </div>
                </div>
                {{csrf_field()}}
                <input type="hidden" name="_method" value="put">
                <input type="hidden" name="id" value="{{$data->id}}">
                <div class="layui-form-item layui-form-text">
                    <label for="remark" class="layui-form-label">
                        描述
                    </label>
                    <div class="layui-input-block">
                        <textarea placeholder="请输入内容" id="remark" name="remark" class="layui-textarea">{{$data->rolename}}</textarea>
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">
                        拥有权限
                    </label>
                    <table  class="layui-table layui-input-block">
                        <td>
                            @foreach($priData as $k => $vo)
        						{{str_repeat('-', 16*$vo['level'])}}
        						<input level_id="{{$vo['level']}}" type="checkbox" id="che_{{$vo['id']}}" name="pri_id[{{$vo['id']}}]" value="{{$vo['id']}}" lay-filter="encrypt" @if( in_array($vo['id'],$rpData)) checked @endif/>
        						<label for="che_{$vo.id}">{{$vo['pri_name']}}</label><br />
        					@endforeach
                        </td>
                    </table>
                </div>

                <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="add">更新</button>
              </div>
            </form>
    </div>
    <script>
    layui.use(['form','layer'], function(){
        $ = layui.jquery;
        var form = layui.form
        ,layer = layui.layer;

        //监听提交
        form.on('submit(add)', function(data){
            $.post("{{url('admin/role/'.$data->id)}}",data.field,function(res){
               if(res.status == 1){
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

        // 为所有的复选框绑定一个点击事件
        form.on('checkbox(encrypt)', function(data){
            // 先获取点击的这个level_id
            var tmp_level_id = level_id =  $(this).attr("level_id");
            if (data.elem.checked) {
                 // 所有的子权限也选中
                 $(this).nextAll(":checkbox").each(function(k,v){
                     if($(v).attr("level_id") > level_id){
                         $(v).attr('checked', true);
                         form.render();
                     }else {
                         return false;
                     }
                 });
                 // 所有的上级权限也选中
                 $(this).prevAll(":checkbox").each(function(k,v){
                     if($(v).attr("level_id") < tmp_level_id)
                     {
                         $(v).attr('checked', true);
                         form.render();
                         tmp_level_id--; // 再找更上一级的
                     }
                 });
             }else {
                 // 所有的子权限也取消
                 $(this).nextAll(":checkbox").each(function(k,v){
                     if($(v).attr("level_id") > level_id){
                         $(v).removeAttr('checked');
                         form.render();
                     }else {
                         return false;
                     }
                 });
             }
         });
     });
    </script>
@endsection
