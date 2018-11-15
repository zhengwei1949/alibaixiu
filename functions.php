<?php
//登录验证
function checkLogin(){
  session_start();
  if(!isset($_SESSION['isLogin']) || $_SESSION['isLogin'] != 1){
    header('location:./login.php');
  }
}
//连接数据库
function connect(){
    $connect = mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);
    return $connect;
}

//只是用来查询
function query($connect,$sql){
  //查询
  $result = mysqli_query($connect,$sql);//得到的是一个对象
  // var_dump($result);
  //查询出来的是一个对象，转换成二维数组
  return fetch($result);
}

function fetch($result){
  $arr = [];
  while($row = mysqli_fetch_assoc($result)){
    $arr[] = $row;
  }
  return $arr;
}

//新增
function insert($connect,$table,$arr){
  $str1 = implode(",",array_keys($arr));
    $str2 = "'".implode("','",array_values($arr))."'";
    $sql = "insert into {$table} (".$str1.") values (".$str2.")";
    $addResult = mysqli_query($connect,$sql);
    return $addResult;
}
?>