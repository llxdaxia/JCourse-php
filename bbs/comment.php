<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/9/17
 * Time: 14:48
 */
include '../base/connect_pdo.php';
include '../base/check.php';
include '../base/config.php';
include '../base/header.php';

$headers = getallheaders();
$author_id = get_UID($headers);

$bbs_id = $_POST['bbsId'];
$objectId = $_POST['objectId'];
$content = $_POST['content'];
$current_time = date("Y-m-d H:i:s");

$sql = "INSERT INTO comment (commenter_id,object_id,content,bbs_id,time) 
VALUES ('$author_id','$objectId','$content','$bbs_id','$current_time')";

$add_comment = $pdo_connect->exec($sql);

$result = array();

if($add_comment){
    $result['info'] = "添加成功";
}else{
    serverError();
}
echo json_encode($result);