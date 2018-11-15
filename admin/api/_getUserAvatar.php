<?php
require_once "../../config.php";
require_once "../../functions.php";
//获取用户id
session_start();//开启session
$user_id = $_SESSION['user_id'];
// echo $user_id;
//通过这个id值去数据库查
$connect = connect();
$sql = "select * from users where id = {$user_id}";
$queryResult = query($connect,$sql);
// print_r($queryResult);
$response = ["code"=>0,"msg"=>"操作失败"];
if($queryResult){
    $response["code"] = 1;
    $response["msg"] = "操作成功";
    //把用户头像和昵称
    $response["avatar"] = $queryResult[0]['avatar'];
    $response["nickname"] = $queryResult[0]['nickname'];
}
header('content-type:application/json;charset=utf8');
echo json_encode($response);
?>