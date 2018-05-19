@extends('layouts.admin')
@section('content')
    <div class="x-nav">
        <span class="layui-breadcrumb">
            <a href="">首页</a>
            <a href="">演示</a>
            <a><cite>导航元素</cite></a>
        </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <xblock>
            <button class="layui-btn" onclick="x_admin_show('添加角色','{{url('admin/role/create')}}')"><i class="layui-icon"></i>添加</button>
            <span class="x-right" style="line-height:40px">共有数据：{{$count}} 条</span>
        </xblock>
        <table class="layui-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>角色名</th>
                    <th>拥有权限规则</th>
                    <th>描述</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $k => $v)
                <tr>
                    <td>{{$v->id}}</td>
                    <td>{{$v->rolename}}</td>
                    <td>{{msubstr($v->pri_name, 0, 20, "utf-8", false)}}</td>
                    <input value="{{$v->pri_name}}" id="pri_name_{{$v->id}}" type="hidden">
                    <td>{{$v->remark}}</td>
                    <td class="td-manage">

                        <a title="详情"  onclick="getinfo({{$v->id}})" href="javascript:;">
                            <i class="layui-icon"></i>
                        </a>

                        <a title="编辑"  onclick="x_admin_show('编辑','{{url('admin/role/'.$v->id.'/edit')}}')" href="javascript:;">
                            <i class="layui-icon">&#xe642;</i>
                        </a>
                        <a title="删除" onclick="member_del(this,'{{$v->id}}')" href="javascript:;">
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

    // 提取信息
    function getinfo(id){
        var rid = "#pri_name_"+id;
        html = "";
        html = "<table width='100%' border='1'><tr>"+$(rid).val()+"</tr></table>";
        layer.open({
            type: 1
            ,title: false //不显示标题栏
            ,closeBtn: false
            ,area: ['300px', '360px']
            ,shade: 0.8
            ,id: 'itarvin' //设定一个id，防止重复弹出
            ,btn: ['关闭']
            ,btnAlign: 'c'
            ,moveType: 1 //拖拽模式，0或者1
            ,content: '<div style="padding: 40px; line-height: 22px; background-color: #393D49; color: #fff; font-weight: 300;word-wrap:break-word; text-align:center;">'+html+'</div>'
            ,success: function(layero){
            }
        });
    }
    /*用户-删除*/
    function member_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            //发异步删除数据
            $(obj).parents("tr").remove();
            layer.msg('已删除!',{icon:1,time:1000});
        });
    }
    </script>
@endsection
