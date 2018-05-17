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
        <div class="layui-row">
            <form class="layui-form layui-col-md12 x-so">
                <input type="text" name="username"  placeholder="请输入用户名" autocomplete="off" class="layui-input">
                <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
            </form>
        </div>
        <xblock>
            <button class="layui-btn" onclick="x_admin_show('添加角色','{{url('admin/config/create')}}')"><i class="layui-icon"></i>添加</button>
            <span class="x-right" style="line-height:40px">共有数据：{{$count}} 条</span>
        </xblock>
        <table class="layui-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>排序</th>
                    <th>标题</th>
                    <th>名称</th>
                    <th>内容</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <form action="" enctype="multipart/form-data" method="post" id="updatecon" >
                @foreach($data as $k => $v)
                <tr>
                    <td>{{$v->id}}</td>
                    <td><input type="text" name="sort_num[]" class="layui-input" value="{{$v->sort_num}}" width="20px"></td>
                    <td>{{$v->title}}</td>
                    <td>{{$v->name}}</td>
                    <td><input type="hidden" name="id[]" value="{{$v->id}}">{!! $v->_html !!}</td>
                    <td class="td-manage">
                        <a title="编辑"  onclick="x_admin_show('编辑','{{url('admin/config/'.$v->id.'/edit')}}')" href="javascript:;">
                            <i class="layui-icon">&#xe642;</i>
                        </a>
                        <a title="删除" onclick="member_del(this,'{{$v->id}}')" href="javascript:;">
                            <i class="layui-icon">&#xe640;</i>
                        </a>
                    </td>
                </tr>
                @endforeach
                </form>
            </tbody>
        </table>
         <button class="layui-btn" class="layui-btn" onclick="hitUpdate()"><i class="layui-icon">ဂ</i>全部更新</button>
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
        layer.confirm('确认要删除吗？',function(index){
            //发异步删除数据
            $(obj).parents("tr").remove();
            layer.msg('已删除!',{icon:1,time:1000});
        });
    }
    function hitUpdate(){
        var sort = $("input[name='sort_num[]']");
        var ids = $("input[name='id[]']");
        var contents = $("input[name='content[]']");
        var token = "{{csrf_token()}}";
        var data = {
            id : returnArray(ids),
            sort_num : returnArray(sort),
            content : returnArray(contents),
            _token : token
        };
        $.ajax({
            type: 'post',
            url: '{{url("admin/config/updateContent")}}',
  		    dataType: 'json',
            data:data,
            success: function(msg){
      		    if(msg.code == '200'){
                    layer.msg(msg.msg, {time: 2000});
                }
            },
        });
    }
    function returnArray(sort){
        var sort_num = [];
        for(var i = 0, j = sort.length; i < j; i++){
            sort_num.push(sort[i].value);
        }
        return sort_num;
    }
    </script>
@endsection
