<?php
require_once "../../config.php";
require_once "../../functions.php";
//获取文章的数据
$connect = connect();
$sql = "select p.title,p.created,p.status,u.nickname,c.name from posts p left join users u on u.id = p.user_id left join categories c on c.id = p.category_id";
$result = query($connect,$sql);
$response = ["code"=>0,"msg"=>"操作失败"];
if($result){
    $response["code"] = 1;
    $response["msg"] = "操作成功";
    $response["data"] = $result;
}
header('content-type:application/json;charset=utf8');
echo json_encode($response);
?>