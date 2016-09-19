<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/9/19
 * Time: 14:10
 */

include '../base/connect_pdo.php';
include '../base/check.php';
include '../base/request.php';
include '../base/config.php';
include '../base/token.php';
include '../base/statusCode.php';

$content = $_REQUEST['content'];
$relation = $_REQUEST['relation'];

$current_time = date("Y-m-d H:i:s");

$insert_sql = "insert into feedback (content,relation,time) 
values('$content','$relation','$current_time')";
$insert = $pdo_connect->exec($insert_sql);

if ($insert) {
    $result['info'] = "提交成功";
} else {
    serverError();
}

echo json_encode($result);
