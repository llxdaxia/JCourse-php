<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/9/17
 * Time: 23:40
 */

include '../base/connect_pdo.php';
include '../base/check.php';
include '../base/config.php';
include '../base/header.php';
include '../base/statusCode.php';

$headers = getallheaders();
$uid = get_UID($headers);

$follow_id = $_POST['id'];

$result = array();

$check_sql = "SELECT * FROM follow_relation WHERE follow_id = '$follow_id' 
AND requester_id = '$uid' LIMIT 1";

$check_result = $pdo_connect->query($check_sql);
$rowNum = $check_result->rowCount();
if ($rowNum == 0) {
    $result['info'] = "你还没有关注";
} else {
    $sql = "DELETE FROM follow_relation WHERE requester_id = '$uid'
  AND follow_id = '$follow_id' LIMIT 1";

    $un_follow = $pdo_connect->exec($sql);

    if ($un_follow) {
        $result['info'] = "取消成功";
    } else {
        serverError();
    }
}

echo json_encode($result);