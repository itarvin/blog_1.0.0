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
    <xblock>
        <button class="layui-btn" onclick="x_admin_show('添加用户','{{url('admin/music/create')}}')"><i class="layui-icon"></i>添加</button>
        <span class="x-right" style="line-height:40px">共有数据：{{$data->total()}} 条</span>
    </xblock>
    <table class="layui-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>标题</th>
                <th>作者</th>
                <th>URL地址</th>
                <th>缩略图</th>
                <th>编辑时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $k => $v)
            <tr>
                <td>{{$v['id']}}</td>
                <td>{{$v['title']}}</td>
                <td>{{$v['author']}}</td>
                <td>{{$v['url']}}</td>
                <td><img src="{{$v['smallimg']}}"></td>
                <td>{{$v['addtime']}}</td>
                <td class="td-manage">
                    <a title="编辑"  onclick="x_admin_show('编辑','{{url('admin/music/'.$v->id.'/edit')}}')" href="javascript:;">
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
function member_del(obj,id){
  layer.confirm('确认要删除吗？',function(index){
      //发异步删除数据
      $.post("{{url('admin/music/')}}/"+id,{'_method':'delete','_token':"{{csrf_token()}}"},function(res){
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
</script>
@endsection
