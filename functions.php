<?php
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
?>