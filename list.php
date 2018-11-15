<?php
$categoryId = $_GET['categoryId'];
require_once "config.php";
require_once "functions.php";
$connect = connect();//连接数据库
$sql = "select p.id,p.title,p.feature,p.created,p.content,p.views,p.likes,c.name,u.nickname,
(select count(*) from comments where comments.post_id = p.id) as commentCount
from posts p
left join categories c on p.category_id = c.id 
left join users u on p.user_id = u.id
where p.category_id = {$categoryId}
limit 10";
$postArr = query($connect,$sql);
// print_r($postArr);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>阿里百秀-发现生活，发现美!</title>
  <link rel="stylesheet" href="static/assets/css/style.css">
  <link rel="stylesheet" href="static/assets/vendors/font-awesome/css/font-awesome.css">
</head>
<body>
  <div class="wrapper">
    <div class="topnav">
      <ul>
        <li><a href="javascript:;"><i class="fa fa-glass"></i>奇趣事</a></li>
        <li><a href="javascript:;"><i class="fa fa-phone"></i>潮科技</a></li>
        <li><a href="javascript:;"><i class="fa fa-fire"></i>会生活</a></li>
        <li><a href="javascript:;"><i class="fa fa-gift"></i>美奇迹</a></li>
      </ul>
    </div>
    <?php include_once "public/_header.php" ?>
    <?php include_once "public/_aside.php" ?>
    <div class="content">
      <div class="panel new">
        <h3>会生活</h3>
        <?php foreach($postArr as $key=>$value){ ?>
        <div class="entry">
          <div class="head">
            <a href="javascript:;"><?php echo $value['title'] ?></a>
          </div>
          <div class="main">
            <p class="info"><?php echo $value['nickname'] ?> 发表于 <?php echo $value['created'] ?></p>
            <p class="brief"><?php echo $value['content'] ?></p>
            <p class="extra">
              <span class="reading">阅读(<?php echo $value['views'] ?>)</span>
              <span class="comment">评论(<?php echo $value['commentCount'] ?>)</span>
              <a href="javascript:;" class="like">
                <i class="fa fa-thumbs-up"></i>
                <span>赞(<?php echo $value['likes'] ?>)</span>
              </a>
              <a href="javascript:;" class="tags">
                分类：<span><?php echo $value['name'] ?></span>
              </a>
            </p>
            <a href="javascript:;" class="thumb">
              <img src="<?php echo $value['feature'] ?>" alt="">
            </a>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
    <div class="footer">
      <p>© 2016 XIU主题演示 本站主题由 themebetter 提供</p>
    </div>
  </div>
</body>
</html>