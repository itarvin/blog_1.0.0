@extends('layouts.admin')
@section('content')
        <div class="x-body">
            <blockquote class="layui-elem-quote">itarvin博客后台</blockquote>
            <fieldset class="layui-elem-field">
              <legend>信息统计</legend>
              <div class="layui-field-box">
                <!-- <table class="layui-table" lay-even>
                    <thead>
                        <tr>
                            <th>统计</th>
                            <th>资讯库</th>
                            <th>图片库</th>
                            <th>产品库</th>
                            <th>用户</th>
                            <th>管理员</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>总数</td>
                            <td>92</td>
                            <td>9</td>
                            <td>0</td>
                            <td>8</td>
                            <td>20</td>
                        </tr>
                        <tr>
                            <td>今日</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>昨日</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>本周</td>
                            <td>2</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>本月</td>
                            <td>2</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                    </tbody>
                </table> -->
                <table class="layui-table">
                <thead>
                    <tr>
                        <th colspan="2" scope="col">服务器信息</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th width="30%">服务器计算机名</th>
                        <td><span id="lbServerName">{{PHP_OS}}</span></td>
                    </tr>
                    <tr>
                        <td>服务器IP地址</td>
                        <td>{{$_SERVER['SERVER_NAME'].' [ '.gethostbyname($_SERVER['SERVER_NAME']).' ]'}}</td>
                    </tr>
                    <tr>
                        <td>服务器域名</td>
                        <td>{{$_SERVER['HTTP_HOST']}}</td>
                    </tr>
                    <tr>
                        <td>服务器端口 </td>
                        <td>{{$_SERVER['SERVER_PORT']}}</td>
                    </tr>
                    <tr>
                        <td>服务器版本 </td>
                        <td>{{$_SERVER['SERVER_SOFTWARE']}}</td>
                    </tr>
                    <tr>
                        <td>本文件所在文件夹 </td>
                        <td>{{$_SERVER['PATH']}}</td>
                    </tr>
                    <tr>
                        <td>系统所在文件夹 </td>
                        <td>{{$_SERVER['PATH']}}</td>
                    </tr>
                    <tr>
                        <td>PHP版本</td>
                        <td>{{PHP_VERSION}}</td>
                    </tr>
                    <tr>
                        <td>服务器的语言种类 </td>
                        <td>{{$_SERVER['HTTP_ACCEPT_LANGUAGE']}}</td>
                    </tr>
                    <tr>
                        <td>.NET Framework 版本 </td>
                        <td>{{zend_version()}}</td>
                    </tr>
                    <tr>
                        <td>服务器当前时间 </td>
                        <td>{{date("Y年n月j日 H:i:s",time())}}</td>
                    </tr>
                    <tr>
                        <td>最大执行时间</td>
                        <td>{{get_cfg_var("max_execution_time")."秒 "}}</td>
                    </tr>
                    <tr>
                        <td>系统版本号</td>
                        <td>{{php_uname('r')}}</td>
                    </tr>
                    <tr>
                        <td>浏览器信息</td>
                        <td>{{$_SERVER['HTTP_USER_AGENT']}}</td>
                    </tr>
                    <tr>
                        <td>通信协议</td>
                        <td>{{$_SERVER['SERVER_PROTOCOL']}}</td>
                    </tr>
                    <tr>
                        <td>当前程序占用内存 </td>
                        <td>{{get_cfg_var ("memory_limit") ? get_cfg_var("memory_limit"):"无"}}</td>
                    </tr>
                    <tr>
                        <td>剩余空间</td>
                        <td>{{round((disk_free_space(".")/(1024*1024)),2).'M'}}</td>
                    </tr>
                    <tr>
                        <td>最大上传限制</td>
                        <td>{{get_cfg_var ("upload_max_filesize")?get_cfg_var ("upload_max_filesize") : "不允许上传附件"}}</td>
                    </tr>
                    <tr>
                        <td>当前SessionID </td>
                        <td>{{session_id()}}</td>
                    </tr>
                    <tr>
                        <td>用户的IP地址</td>
                        <td>{{$_SERVER['REMOTE_ADDR']}}</td>
                    </tr>
                    <tr>
                        <td>当前系统用户名 </td>
                        <td>{{Get_Current_User()}}</td>
                    </tr>
                </tbody>
            </table>
              </div>
            </fieldset>
        </div>
@endsection
