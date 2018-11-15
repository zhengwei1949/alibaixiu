<?php
require_once "../config.php";
require_once "../functions.php";
checkLogin();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
</head>
<body>

  <div class="main">
    <?php include_once "public/_navbar.php" ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有文章</h1>
        <a href="post-add.php" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <form class="form-inline">
          <select name="" class="form-control input-sm">
            <option value="">所有分类</option>
            <option value="">未分类</option>
          </select>
          <select name="" class="form-control input-sm">
            <option value="">所有状态</option>
            <option value="">草稿</option>
            <option value="">已发布</option>
          </select>
          <button class="btn btn-default btn-sm">筛选</button>
        </form>
        <ul class="pagination pagination-sm pull-right">
          <!-- <li><a href="#">上一页</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">下一页</a></li> -->
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          
        </tbody>
      </table>
    </div>
  </div>
  <?php $current_page = 'posts' ?>
  <?php include_once "public/_aside.php" ?>

  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../static/assets/vendors/art-template/template-web.js"></script>
  <script type="text/template" id="tpl">
      <%
        var statusData = {
          "drafted":"草稿",
          "published":"已发布",
          "trashed":"已作废"
        };
      %>
      <% for(var i=0;i<data.length;i++){ %>
      <tr>
          <td class="text-center"><input type="checkbox"></td>
          <td><%=data[i].title%></td>
          <td><%=data[i].nickname%></td>
          <td><%=data[i].name%></td>
          <td class="text-center"><%=data[i].created%></td>
          <td class="text-center"><%=statusData[data[i].status]%></td>
          <td class="text-center">
            <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
            <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
          </td>
        </tr>
        <% } %>
  </script>
  <script>
    var pageSize = 20;//每一页只显示20条数据
    var currentPage = 4;//默认显示第一磁数据
    var totalPage;
    var size = 5;//页码只显示5页
    
    function renderPage(){
      var html = '<li class="prev"><a href="#">上一页</a></li>';
      if(currentPage <= 3){
        var first = 1;
        var last = first + 4;
      }else if(currentPage >= totalPage - 2){
        var last = totalPage;
        var first = last - 4;
      }else{
        var first = currentPage - 2;
        var last = currentPage + 2;
      }
      for(var i=first;i<=last;i++){
        if(i == currentPage){
          html += '<li class="active"><a href="#">'+i+'</a></li>';
        }else{
          html += '<li><a href="#">'+i+'</a></li>';
        }
      }
      html += '<li class="next"><a href="#">下一页</a></li>';
      $('.pagination').html(html);
    }
    

    $('.pagination').on('click','.prev',function(){
      if(currentPage == 1)return;
      currentPage--;
      console.log(currentPage);
      renderContent();
    })

    $('.pagination').on('click','.next',function(){
      if(currentPage == totalPage)return;
      currentPage++;
      console.log(currentPage);
      renderContent();
    })

    function renderContent(){
      //第一次请求，把数据请求回来，动态生成表格
      //其他参数:beforeSend在发送之前可以使用return false进行取消,timeout超时,error一般用于超时的时候会触发,async同步还是异步
      $.ajax({
        type:'post',//get或post
        url:'api/_getPostsData.php',//请求的地址
        data:{
          currentPage:currentPage,
          pageSize:pageSize
        },//如果不需要传，则注释掉 请求的参数，a=1&b=2或{a:1,b:2}或者jq中的serialize方法，或者formData收集
        dataType:'json',//text,json,xml,jsonp
        success:function(res){//成功的回调函数
          // console.log(res)
          var html = template('tpl',res);
          $('tbody').html(html);
          totalPage = Math.ceil(res.count / pageSize);
          renderPage();
        }
      })
    }
    renderContent();

    //1. 请求后台，把文章数据请求出来，动态的渲染表格结构
    $(function(){
      
    })
  </script>
</body>
</html>
