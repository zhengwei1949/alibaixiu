<?php
require_once "./config.php";
$connect = mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);//连接数据库
$sql = "select * from categories where id != 1";
$queryResult = mysqli_query($connect,$sql);
$arr = [];
while($row = mysqli_fetch_assoc($queryResult)){
    $arr[] = $row;
}
?>
<div class="header">
    <h1 class="logo"><a href="index.php"><img src="static/assets/img/logo.png" alt=""></a></h1>
    <ul class="nav">
    <?php foreach($arr as $key=>$value){ ?>
    <li><a href="javascript:;"><i class="fa fa-glass"></i><?php echo $value['name'] ?></a></li>
    <?php } ?>
    </ul>
    <div class="search">
    <form>
        <input type="text" class="keys" placeholder="输入关键字">
        <input type="submit" class="btn" value="搜索">
    </form>
    </div>
    <div class="slink">
    <a href="javascript:;">链接01</a> | <a href="javascript:;">链接02</a>
    </div>
</div>