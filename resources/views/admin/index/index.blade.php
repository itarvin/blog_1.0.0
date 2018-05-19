@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="logo"><a href="./index.html">X-admin v2.0</a></div>
        <div class="left_open">
            <i title="展开左侧栏" class="iconfont">&#xe699;</i>
        </div>
        <ul class="layui-nav left fast-add" lay-filter="">
          <li class="layui-nav-item">
            <a href="javascript:;">+新增</a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
              <dd><a onclick="x_admin_show('资讯','http://www.baidu.com')"><i class="iconfont">&#xe6a2;</i>资讯</a></dd>
              <dd><a onclick="x_admin_show('图片','http://www.baidu.com')"><i class="iconfont">&#xe6a8;</i>图片</a></dd>
               <dd><a onclick="x_admin_show('用户','http://www.baidu.com')"><i class="iconfont">&#xe6b8;</i>用户</a></dd>
            </dl>
          </li>
        </ul>
        <ul class="layui-nav right" lay-filter="">
          <li class="layui-nav-item">
            <a href="javascript:;">admin</a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
              <dd><a onclick="x_admin_show('个人信息','http://www.baidu.com')">个人信息</a></dd>
              <dd><a onclick="x_admin_show('切换帐号','http://www.baidu.com')">切换帐号</a></dd>
              <dd><a href="{{url('admin/logout')}}">退出</a></dd>
            </dl>
          </li>
          <li class="layui-nav-item to-index"><a href="/">前台首页</a></li>
        </ul>

    </div>
    <!-- 顶部结束 -->
    <!-- 中部开始 -->
     <!-- 左侧菜单开始 -->
    <div class="left-nav">
      <div id="side-nav">
        <ul id="nav">
            <!-- @foreach($btns as $k => $v)
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe697;</i>
                    <cite>{{$v['pri_name']}}</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    @foreach($v['children'] as $k1 => $v1)
                    <li>
                        <a _href="{{url($v1['module_name'].'/'.$v1['controller_name'].'/'.$v1['action_name'])}}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>{{$v1['pri_name']}}</cite>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </li>
            @endforeach -->
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe723;</i>
                    <cite>资讯管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="{{url('admin/substance')}}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>博文列表</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="{{url('admin/news')}}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>相册列表</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="{{url('admin/music')}}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>music列表</cite>
                        </a>
                    </li >
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe726;</i>
                    <cite>管理员管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="{{url('admin/user')}}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>管理员列表</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="{{url('admin/role')}}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>角色管理</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="{{url('admin/rule')}}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>权限管理</cite>
                        </a>
                    </li >
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe6ce;</i>
                    <cite>系统统计</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="{{url('admin/log')}}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>日志列表</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="{{url('admin/config')}}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>配置列表</cite>
                        </a>
                    </li >
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe6f1;</i>
                    <cite>爬虫项目</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="{{url('admin/project')}}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>腾讯招聘</cite>
                        </a>
                    </li >
                </ul>
            </li>
        </ul>
      </div>
    </div>
    <div class="x-slide_left"></div>
    <!-- 左侧菜单结束 -->
    <!-- 右侧主体开始 -->
    <div class="page-content">
        <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
          <ul class="layui-tab-title">
            <li>我的桌面</li>
          </ul>
          <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <iframe src="{{url('admin/welcome')}}" frameborder="0" scrolling="yes" class="x-iframe"></iframe>
            </div>
          </div>
        </div>
    </div>
    <div class="page-content-bg"></div>
    <!-- 右侧主体结束 -->
    <!-- 中部结束 -->
    <!-- 底部开始 -->
    <div class="footer">
        <div class="copyright">Copyright ©2017 x-admin v2.3 All Rights Reserved</div>
    </div>
    <!-- 底部结束 -->
@endsection
