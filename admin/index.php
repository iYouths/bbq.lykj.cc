<?php
    session_start();
    if (isset($_SESSION['login']) && $_SESSION['login'] > 0) {
        # 如果存在登录记录则进入后台。注意：因为Cookie被微信禁用，导致$_SESSION，所以用微信登录是无法打开后台的。
        
    }else {
        # 使用脚本重定向回到登录界面
        $url="login.php";
        echo "<script language=\"javascript\">";
        echo "location.href=\"$url\"";
        echo "</script>";
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>表白墙后台管理</title>
    <link rel="stylesheet" href="layui/css/layui.css">
    <style>
        body, html, .layui-table-view{
            margin:0;
            padding:0;
        }
    </style>
</head>
<body>
    <table class="layui-table" lay-data="{height:'full-0', url:'admin.php', page:true, id:'test', even: true}" lay-filter="test">
    <thead>
        <tr>
        <th lay-data="{field:'id', width:80, sort: true}">ID</th>
        <th lay-data="{field:'nickName', width:120, sort: true, event: 'setNickName'}">昵称</th>
        <th lay-data="{field:'trueName', width:120, sort: true, event: 'setTrueName'}">真实名字</th>
        <th lay-data="{field:'gender', width:80, sort: true, event: 'setGender'}">性别</th>
        <th lay-data="{field:'toWho', width:120, sort: true, event: 'setToWho'}">表白对象</th>
        <th lay-data="{field:'itsGender', width:120, sort: true, event: 'setItsGender'}">对象性别</th>
        <th lay-data="{field:'contents', width:350, sort: true, event: 'setContents'}">内容</th>
        <th lay-data="{field:'love', width:80, sort: true, event: 'setLove'}">点赞</th>
        <th lay-data="{field:'email', width:80, sort: true, event: 'setEmail'}">邮箱</th>
        <th lay-data="{field:'isSended', width:100, sort: true}">发送状态</th>
        <th lay-data="{field:'isDisplay', width:70, sort: true}">隐藏</th>
        <th lay-data="{field:'ip', width:100, sort: true}">ip</th>
        <th lay-data="{field:'mtime', width:180, sort: true}">修改时间</th>
        <th lay-data="{fixed: 'right', width:320, align:'center', toolbar: '#barDemo'}"></th>
        </tr>
    </thead>
    </table>
    <script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-primary layui-btn-mini" lay-event="getComment">查看评论</a>
    <a class="layui-btn layui-btn-mini" lay-event="getGuessHistory">查看猜名字历史</a>
    <a class="layui-btn layui-btn-mini" lay-event="resendEmail">重发邮件</a>
    <a class="layui-btn layui-btn-danger layui-btn-mini" lay-event="del">删除</a>
    </script>
    <script src="layui/layui.all.js"></script>
    <script>
        layui.use('table', function(){
            var table = layui.table;

            //监听工具条
            table.on('tool(test)', function(obj){
                var data = obj.data;
                if(obj.event === 'getComment'){
                // layer.msg('ID：'+ data.id + ' 的查看操作');
                $.ajax({
                    type: "post",
                    url: "admin.php",
                    data: {act:"getComment", id:data.id},
                    dataType: "html",
                    success: function (response) {
                        
                    }
                });
                    
                } else if(obj.event === 'del'){
                layer.confirm('真的删除行么', function(index){
                    obj.del();
                    layer.close(index);
                });
                } else if(obj.event === 'getGuessHistory'){
                // layer.alert('编辑行：<br>'+ JSON.stringify(data))

                }
            });

            //监听单元格事件
            table.on('tool(test)', function(obj){
                var data = obj.data;
                if(obj.event === 'setSign'){
                layer.prompt({
                    formType: 2
                    ,title: '修改 ID 为 ['+ data.id +'] 的用户签名'
                    ,value: data.sign
                }, function(value, index){
                    layer.close(index);
                    
                    //这里一般是发送修改的Ajax请求
                    
                    //同步更新表格和缓存对应的值
                    obj.update({
                    sign: value
                    });
                });
                }
            });
        });
    </script>
    
</body>
</html>