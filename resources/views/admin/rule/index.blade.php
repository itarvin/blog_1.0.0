@extends('layouts.admin')
@section('content')
    <div class="x-nav">
        <span class="layui-breadcrumb">
            <a href="">首页</a>
            <a href="">演示</a>
            <a><cite>导航元素88</cite></a>
        </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <div class="layui-row">
            <form class="layui-form layui-col-md12 x-so layui-form-pane">
                <input class="layui-input" placeholder="权限名" name="pri_name" >
                <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
            </form>
        </div>
        <xblock>
            <button class="layui-btn" onclick="x_admin_show('添加用户','{{url('admin/rule/create')}}')"><i class="layui-icon"></i>添加</button>
            <span class="x-right" style="line-height:40px">共有数据：{{$count}} 条</span>
        </xblock>
        <table class="layui-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>权限规则</th>
                    <th>权限名称</th>
                    <th>所属分类</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $k => $v)
                <tr>
                    <td>{{$v['id']}}</td>
                    <td>{{$v['module_name']}}/{{$v['controller_name']}}/{{$v['action_name']}}</td>
                    <td>{{str_repeat('-', 8*$v['level'])}}{{$v['pri_name']}}</td>
                    <td>{{$v['parent_id']}}</td>
                    <td class="td-manage">
                        <a title="编辑"  onclick="x_admin_show('编辑','{{url('admin/rule/'.$v->id.'/edit')}}')" href="javascript:;">
                            <i class="layui-icon">&#xe642;</i>
                        </a>
                        <a title="删除" onclick="member_del(this,'{{$v['id']}}')" href="javascript:;">
                            <i class="layui-icon">&#xe640;</i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
    layui.use('laydate', function(){
        var laydate = layui.laydate;

        //执行一个laydate实例
        laydate.render({
            elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
            elem: '#end' //指定元素
        });
    });

    /*用户-删除*/
    function member_del(obj,id){
        //发异步删除数据
        $.post("{{url('admin/rule/')}}/"+id,{'_method':'delete','_token':"{{csrf_token()}}"},function(res){
            if(res.code == 200){
                $(obj).parents("tr").remove();
                layer.msg(res.msg,{icon:1,time:1000});
            }else{
                layer.msg(res.msg, {time: 2000});
            }
        },'json');
        return false;
    }
    </script>
@endsection
