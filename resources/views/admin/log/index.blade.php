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
            <span class="x-right" style="line-height:40px">共有数据：{{$data->total()}} 条</span>
        </xblock>
        <table class="layui-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>操作时间</th>
                    <th>操作地区</th>
                    <th>IP地址</th>
                    <th>客户端信息</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $k => $v)
                <tr>
                    <td>{{$v->id}}</td>
                    <td>{{$v->login_time}}</td>
                    <td>{{$v->region}}/{{$v->city}}</td>
                    <td>{{$v->ip}}</td>
                    <td>{{$v->useragent}}</td>
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
@endsection
