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
              <button class="btn btn-primary" type="button" id="btn-edit" style="display:none;">编辑完成</button>
              <button class="btn btn-primary" type="button" id="btn-cancle" style="display:none;">取消编辑</button>
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a id="delAll" class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
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
        <tr data-id="<%=data[i].id%>">
          <td class="text-center"><input type="checkbox"></td>
          <td><%=data[i].name%></td>
          <td><%=data[i].slug%></td>
          <td><%=data[i].classname%></td>
          <td class="text-center">
            <a href="javascript:;" class="btn btn-info btn-xs edit" data-id="<%=data[i].id%>">编辑</a>
            <a href="javascript:;" class="btn btn-danger btn-xs del">删除</a>
          </td>
        </tr>
      <% } %>
  </script>
  <script>
  $(function(){
    function render(){
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
    }

    render();


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
              render();
            }
          }
        })
      })

      //编辑第一步：点击编辑按钮显示编辑完成编辑取消按钮
      $('tbody').on('click','.edit',function(){
        $('#btn-add').hide();
        $('#btn-edit').show();
        $('#btn-cancle').show();
        var id = $(this).attr('data-id');
        $('#btn-edit').attr('data-id',id);
        var name = $(this).parents('tr').find('td:eq(1)').text();
        var slug = $(this).parents('tr').find('td:eq(2)').text();
        var classname = $(this).parents('tr').find('td:eq(3)').text();
        $('#name').val(name);
        $('#slug').val(slug);
        $('#classname').val(classname);
      })
      
      //给编辑完成添加点击事件
      $('#btn-edit').on('click',function(){
        var name = $('#name').val();
        var slug = $('#slug').val();
        var classname = $('#classname').val();
        var id = $(this).attr('data-id');
        //其他参数:beforeSend在发送之前可以使用return false进行取消,timeout超时,error一般用于超时的时候会触发,async同步还是异步
        $.ajax({
          type:'post',//get或post
          url:'api/_updateCategory.php',//请求的地址
          data:{
            id:id,
            name:name,
            classname:classname,
            slug:slug
          },//如果不需要传，则注释掉 请求的参数，a=1&b=2或{a:1,b:2}或者jq中的serialize方法，或者formData收集
          dataType:'json',//text,json,xml,jsonp
          success:function(res){//成功的回调函数
            // console.log(res)
            if(res.code == 1){
              location.reload();//刷新当前页面
            }
          }
        })
      })
      
      //取消编辑
      $('#btn-cancle').on('click',function(){
        $('#add-btn').show();
        $('#add-edit').hide();
        $('#add-cancle').hide();
        document.querySelector('#myform').reset();
      })

      //删除功能
      $('tbody').on('click','.del',function(){
        var row = $(this).parents('tr');
        var id = $(this).parents('tr').attr('data-id');
        //其他参数:beforeSend在发送之前可以使用return false进行取消,timeout超时,error一般用于超时的时候会触发,async同步还是异步
        $.ajax({
          type:'post',//get或post
          url:'api/_delCategory.php',//请求的地址
          data:{
            id:id
          },//如果不需要传，则注释掉 请求的参数，a=1&b=2或{a:1,b:2}或者jq中的serialize方法，或者formData收集
          dataType:'json',//text,json,xml,jsonp
          success:function(res){//成功的回调函数
            // console.log(res)
            if(res.code == 1){
              row.remove();
            }
          }
        })
      })

      //全选功能的实现
      $('thead input').on('click',function(){
        var status = $(this).prop('checked');
        $('tbody input').prop('checked',status);
        if(status){
          $('#delAll').show();
        }else{
          $('#delAll').hide();
        }
      })
      //使用事件委托的方式为别的多选框注册点击事件
      $('tbody').on('click','input',function(){
        //控制全选的多选框是否选中，只有当所选的多选框都选中，全选才选中
        var all = $('thead input');
        var cks = $('tbody input');
        //如果cks里面的所有的多选框都选中了，全选也选中了
        all.prop('checked',cks.size() == $('tbody input:checked').size())
        if($('tbody input:checked').size() >= 2){
          $('#delAll').show();
        }else{
          $('#delAll').hide();
        }
      })

      //点击批量删除
      $('#delAll').on('click',function(){
        //准备好的收集
        //收集所有的选中的id，发送到服务器进行数据的删除
        var cks = $('tbody input:checked');
        //遍历数组，找到所有选中的id
        var ids = [];
        cks.each(function(index,el){
          var id = $(el).parents('tr').attr('data-id');
          ids.push(id);
        })
        //其他参数:beforeSend在发送之前可以使用return false进行取消,timeout超时,error一般用于超时的时候会触发,async同步还是异步
        $.ajax({
          type:'post',//get或post
          url:'api/_delCategories.php',//请求的地址
          data:{ids:ids},//如果不需要传，则注释掉 请求的参数，a=1&b=2或{a:1,b:2}或者jq中的serialize方法，或者formData收集
          dataType:'json',//text,json,xml,jsonp
          success:function(res){//成功的回调函数
            // console.log(res)
            if(res.code == 1){
              cks.parents('tr').remove();
              $('#delAll').hide();
            }
          }
        })
      })
  })
  </script>
</body>
</html>
