<?php
$email = $_POST['email'];
$password = $_POST['password'];
require_once "../../config.php";
require_once "../../functions.php";
//连接数据库
$connect = connect();
//准备sql
$sql = "select * from users where email = '{$email}' and password = '{$password}' and status = 'activated'";
//查询
$queryResult = query($connect,$sql);
// print_r($queryResult);
$response = ["code"=>0,"msg"=>"失败"];
if($queryResult){
    $response["code"] = 1;
    $response["msg"] = "成功";
}
header('content-type:application/json;charset=utf8');
echo json_encode($response);
?>
