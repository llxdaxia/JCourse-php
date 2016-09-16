<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/9/14
 * Time: 14:50
 */
include '../base/connect_pdo.php';
include '../base/check.php';
include '../base/config.php';
include '../base/header.php';

$headers = getallheaders();
$author_id = get_UID($headers);

$pictures = $_POST['pictures'];
$content = $_POST['content'];
$title = $_POST['title'];
$current_time = date("Y-m-d H:i:s");

$sql = "INSERT INTO bbs (author_id,title,content,pictures,time) 
VALUES ('$author_id','$title','$content','$pictures','$current_time')";

$add_bbs = $pdo_connect->exec($sql);
if($add_bbs){
    $result['info'] = "添加成功";
}else{
    serverError();
}
echo json_encode($result);