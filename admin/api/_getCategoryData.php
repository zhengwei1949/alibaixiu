<?php
//后端php做的事情
require_once "../../config.php";
require_once "../../functions.php";
//连接数据库
$connect = connect();
//准备sql 
$sql = "select * from categories";
//查询
$queryResult = query($connect,$sql);
$response = ["code"=>0,"msg"=>"失败"];
if($queryResult){
    $response["code"] = 1;
    $response["msg"] = "成功";
    $response["data"] = $queryResult;
}
header('content-type:application/json;charset=utf8');
echo json_encode($response);
?>