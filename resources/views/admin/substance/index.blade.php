@extends('layouts.admin')
@section('content')
<div class="x-nav">
    <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">演示</a>
        <a><cite>导航元素</cite></a>
    </span>
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i>
    </a>
</div>
<div class="x-body">
    <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so" action="{{url('admin/user/search')}}" method="post">
            <input class="layui-input" placeholder="开始日" name="start" id="start">
            <input type="hidden" name="start" value="{{ csrf_token() }}">
            <input class="layui-input" placeholder="截止日" name="end" id="end">
            <input type="text" name="username"  placeholder="请输入用户名" autocomplete="off" class="layui-input">
            <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
    </div>
    <xblock>
        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
        <button class="layui-btn" onclick="x_admin_show('添加用户','{{url('admin/substance/create')}}')"><i class="layui-icon"></i>添加</button>
        <span class="x-right" style="line-height:40px">共有数据：{{$data->total()}} 条</span>
    </xblock>
    <table class="layui-table">
        <thead>
            <tr>
                <th><div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div></th>
                <th>ID</th>
                <th>标题</th>
                <th>作者</th>
                <th>点击数</th>
                <th>缩略图</th>
                <th>编辑时间</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $k => $v)
            <tr>
                <td><div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='2'><i class="layui-icon">&#xe605;</i></div></td>
                <td>{{$v['id']}}</td>
                <td>{{$v['title']}}</td>
                <td>{{$v['username']}}</td>
                <td>{{$v['hits']}}</td>
                <td><img src="{{$v['mid_picture']}}"></td>
                <td>{{$v['createtime']}}</td>
                <td class="td-status">
                    @if ($v['status'] == 1)
                        <span class="layui-btn layui-btn-normal layui-btn-mini layui-btn-disabled">已停用</span></td>
                    @elseif ($v['status'] == 0)
                        <span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span></td>
                    @endif
                <td class="td-manage">
                    <a onclick="member_stop(this,'10001')" href="javascript:;"  title="启用">
                        <i class="layui-icon">&#xe601;</i>
                    </a>
                    <a title="编辑"  onclick="x_admin_show('编辑','{{url('admin/substance/'.$v->id.'/edit')}}')" href="javascript:;">
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
    <div class="page">
        <div>
            {!! $data->links() !!}
        </div>
    </div>
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

/*用户-停用*/
// function member_stop(obj,id){
//     layer.confirm('确认要停用吗？',function(index){
//
//         if($(obj).attr('title')=='启用'){
//
//             //发异步把用户状态进行更改
//             $(obj).attr('title','停用')
//             $(obj).find('i').html('&#xe62f;');
//
//             $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
//             layer.msg('已停用!',{icon: 5,time:1000});
//
//         }else{
//             $(obj).attr('title','启用')
//             $(obj).find('i').html('&#xe601;');
//
//             $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
//             layer.msg('已启用!',{icon: 5,time:1000});
//         }
//     });
// }


function member_del(obj,id){
  layer.confirm('确认要删除吗？',function(index){
      //发异步删除数据
      $.post("{{url('admin/substance/')}}/"+id,{'_method':'delete','_token':"{{csrf_token()}}"},function(res){
          if(res.code == 200){
              $(obj).parents("tr").remove();
              layer.msg(res.msg,{icon:1,time:1000});
          }else{
              layer.msg(res.msg, {time: 2000});
          }
      },'json');
      return false;
  });
}
// function delAll (argument) {
//
//     var data = tableCheck.getData();
//
//     layer.confirm('确认要删除吗？'+data,function(index){
//     //捉到所有被选中的，发异步进行删除
//         layer.msg('删除成功', {icon: 1});
//         $(".layui-form-checked").not('.header').parents('tr').remove();
//     });
// }
</script>
@endsection
