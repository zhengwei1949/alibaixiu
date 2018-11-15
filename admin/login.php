<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
</head>
<body>
  <div class="login">
    <form class="login-wrap">
      <img class="avatar" src="../static/assets/img/default.png">
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style="display:none;" id="msg">
        <strong>错误！</strong> <span id="text">用户名或密码错误！</span>
      </div>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" type="email" class="form-control" placeholder="邮箱" autofocus>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" type="password" class="form-control" placeholder="密码">
      </div>
      <a class="btn btn-primary btn-block" href="javascript:;" id="login-btn">登 录</a>
    </form>
  </div>
  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script>
  $(function(){
    $('#login-btn').on('click',function(){
      var email = $('#email').val();
      var password = $('#password').val();
      // wfewe1212fwef@qq.com 
      // Email: ^\w+@\w+\.\w+$

      // 或者类似视频中的：^\w+[@]\w+[.]\w+$ 作用完全一样

      // 元字符
      // \d 匹配数字
      // \w 匹配字母或数字或下划线或汉字
      // \s 匹配任意的空白符     
      // \D,\W,\S
      // . 任意字符
      // \. 真正的点
      // ^ 开始
      // $ 结束

      // 量词
      // {4,7} 最少出现4次，最多出现7次
      // {4,} 最少出现4次
      // {4}正好出现4次
      // + : {1,}
      // ? : {0,1}
      // * : {0,}

      // [a-z] 代表的是a或者b或者....z
      // [0-9a-zA-Z] [012345....]
      var reg = /\w+@\w+\.\w+/;
      if(!reg.test(email)){
        $('#msg').show();
        $('#text').html('邮箱格式不对');
        return;
      }
      $.ajax({
        type:'post',//get或post
        url:'./api/_userLogin.php',//请求的地址
        data:{
          email:email,
          password:password
        },//如果不需要传，则注释掉 请求的参数，a=1&b=2或{a:1,b:2}或者jq中的serialize方法，或者formData收集
        dataType:'json',//text,json,xml,jsonp
        success:function(res){//成功的回调函数
          // console.log(res)
          if(res.code == 1){
            location.href = 'index.php';
          }else{
            $('#msg').show();
            $('#text').html('用户名或密码错误');
          }
        }
      })
    })
  })
  </script>
</body>
</html>
