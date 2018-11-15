<?php
require_once "../../config.php";
require_once "../../functions.php";
//获取id值
$id = $_POST['id'];
$connect = connect();
$slug = $_POST['slug'];
$name = $_POST['name'];
$classname = $_POST['classname'];
$sql = "update categories set slug = '{$slug}',name = '{$name}',classname = '{$classname}' where id = {$id}";
$queryResult = mysqli_query($connect,$sql);
$response = ["code"=>0,"msg"=>"操作失败"];
if($queryResult){
    $response["code"] = 1;
    $response["msg"] = "操作成功";
}
header('content-type:application/json;charset=utf8');
echo json_encode($response);
?>

