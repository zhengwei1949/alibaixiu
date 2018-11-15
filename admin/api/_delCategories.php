<?php
$ids = $_POST["ids"];
require_once "../../config.php";
require_once "../../functions.php";
//连接数据库
$connect = connect();
//删除的sql语句
$sql = "delete from categories where id in (".implode(",",$ids).")";
//执行sql语句
$result = mysqli_query($connect,$sql);
//把结果返回
$response = ["code"=>0,"msg"=>"操作失败"];
if($result){
    $response["code"] = 1;
    $response["msg"] = "操作成功";
}
header('content-type:application/json;charset=utf8');
echo json_encode($response);
?>