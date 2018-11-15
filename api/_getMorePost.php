<?php
$categoryId = $_POST['categoryId'];//要哪种类型的数据
$currentPage = $_POST['currentPage']; //当前要获取第几页数据
$pageSize = $_POST['pageSize'];//要多少条数据
require_once "../config.php";
require_once "../functions.php";
$connect = connect();//连接数据库
$offset = ($currentPage - 1) * $pageSize;//索引
$sql = "select p.id,p.title,p.feature,p.created,p.content,p.views,p.likes,c.name,u.nickname,
(select count(*) from comments where comments.post_id = p.id) as commentCount
from posts p
left join categories c on p.category_id = c.id 
left join users u on p.user_id = u.id
where p.category_id = {$categoryId}
limit {$offset},{$pageSize}";//准备一个sql语句
$queryResult = query($connect,$sql);//变量的名字是可以随便写

$response = ["code"=>0,"msg"=>"操作失败"];//不管成功还是失败，前台都能拿到数据
if($queryResult){
    $response["code"] = 1;//成功
    $response["msg"] = "操作成功";
    $response["data"] = $queryResult;
}
header('content-type:application/json;charset=utf8');
echo json_encode($response);
?>