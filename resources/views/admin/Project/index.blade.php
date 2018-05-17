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
            <span class="x-right" style="line-height:40px">共有数据：{{$data->total()}} 条</span>
        </xblock>
        <table class="layui-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>公司</th>
                    <th>职位</th>
                    <th>发布时间</th>
                    <th>地点</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $k => $v)
                <tr>
                    <td>{{$v->id}}</td>
                    <td>{{$v->company}}</td>
                    <td>{{$v->occupation}}</td>
                    <td>{{$v->addtime}}</td>
                    <td>{{$v->address}}</td>
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
