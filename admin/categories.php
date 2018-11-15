<?php
require_once "../config.php";
require_once "../functions.php";
checkLogin();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
</head>
<body>

  <div class="main">
    <?php include_once "public/_navbar.php" ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style="display:none;">
        <strong>错误！</strong><span>发生XXX错误</span>
      </div>
      <div class="row">
        <div class="col-md-4">
          <form id="myform">
            <h2>添加新分类目录</h2>
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <label for="classname">类名</label>
              <input id="classname" class="form-control" name="classname" type="text" placeholder="classname">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="button" id="btn-add">添加</button>
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>名称</th>
                <th>Slug</th>
                <th>classname</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php $current_page = 'categories' ?>
  <?php include_once "public/_aside.php" ?>

  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../static/assets/vendors/art-template/template-web.js"></script>
  <script type="text/template" id="tpl">
      <% for(var i=0;i<data.length;i++){ %>
        <tr>
          <td class="text-center"><input type="checkbox"></td>
          <td><%=data[i].name%></td>
          <td><%=data[i].slug%></td>
          <td><%=data[i].classname%></td>
          <td class="text-center">
            <a href="javascript:;" class="btn btn-info btn-xs edit">编辑</a>
            <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
          </td>
        </tr>
      <% } %>
  </script>
  <script>
  $(function(){
    $.ajax({
      type:'post',//get或post
      url:'api/_getCategoryData.php',//请求的地址
      // data:{},//如果不需要传，则注释掉 请求的参数，a=1&b=2或{a:1,b:2}或者jq中的serialize方法，或者formData收集
      dataType:'json',//text,json,xml,jsonp
      success:function(res){//成功的回调函数
        console.log(res)
        // template('模板id',数据(一定要是对象))
        var html = template('tpl',res);
        $('tbody').html(html);
      }
    })


    //新增
    $('#btn-add').on('click',function(){
        var name = $('#name').val();
        var slug = $('#slug').val();
        var classname = $('#classname').val();
        //验证数据是否为空
        if(name == ""){
          $('.alert').show();
          $('.alert span').text('用户名不能为空');
          return;
        }
        if(slug == ""){
          $('.alert').show();
          $('.alert span').text('别名不能为空');
          return;
        }
        if(classname == ""){
          $('.alert').show();
          $('.alert span').text('类名不能为空');
          return;
        }
        $.ajax({
          type:'post',//get或post 安全
          url:'api/_addCategory.php',//请求的地址
          data:$('#myform').serialize(),
          // data:{
          //   name:name,
          //   slug:slug,
          //   classname:classname
          // },//如果不需要传，则注释掉 请求的参数，a=1&b=2或{a:1,b:2}或者jq中的serialize方法，或者formData收集
          dataType:'json',//text,json,xml,jsonp
          success:function(res){//成功的回调函数
            // console.log(res)
            if(res.code == 0){
              $('.alert').show();
              $('.alert span').text(res.msg);
            }else if(res.code == 1){
              
            }
          }
        })
      })
  })
  </script>
</body>
</html>
