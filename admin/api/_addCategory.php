<?php
require_once "../../config.php";
require_once "../../functions.php";
//验证用户的用户名是否重复 
// print_r($_POST);
$name = $_POST['name'];
//把用户传入的数据插入到数据库
//连接数据库
$connect = connect();
//准备 sql
$sql = "select count(*) as count from categories where name = '{$name}'";
//查询
$countResult = query($connect,$sql);
// print_r($countResult);
$count = $countResult[0]['count'];
$response = ["code"=>0,"msg"=>"操作失败"];
if($count == 1){
    $response["msg"] = "分类名重复了";
}else{
    
}
header('content-type:application/json;charset=utf8');
echo json_encode($response);
?>