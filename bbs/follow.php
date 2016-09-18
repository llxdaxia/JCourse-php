<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/9/17
 * Time: 21:49
 */
include '../base/connect_pdo.php';
include '../base/check.php';
include '../base/config.php';
include '../base/header.php';
include '../base/statusCode.php';

$headers = getallheaders();
$uid = get_UID($headers);

$follow_id = $_POST['id'];
$current_time = date("Y-m-d H:i:s");

$result = array();

$check_sql = "SELECT * FROM follow_relation WHERE follow_id = '$follow_id' 
AND requester_id = '$uid' LIMIT 1";

$check_result = $pdo_connect->query($check_sql);
$rowNum = $check_result->rowCount();
if ($rowNum > 0) {
    $result['info'] = "你已经关注过了";
} else {
    $sql = "INSERT INTO follow_relation (requester_id,follow_id,time) 
VALUES ('$uid','$follow_id','$current_time')";

    $follow = $pdo_connect->exec($sql);

    if ($follow) {
        $result['info'] = "关注成功";
    } else {
        serverError();
    }
}

echo json_encode($result);
