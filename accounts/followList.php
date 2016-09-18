<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/9/17
 * Time: 22:34
 *
 * 我关注的人列表
 */

include '../base/connect_pdo.php';
include '../base/check.php';
include '../base/token.php';
include '../base/header.php';
include '../base/statusCode.php';

$headers = getallheaders();
$uid = get_UID($headers);

$sql = "SELECT * FROM follow_relation WHERE requester_id = '$uid' ORDER BY time DESC";
$query = $pdo_connect->query($sql);
$rows = $query->fetchAll();

$result = array();
$index = 0;
foreach ($rows as $row){

    //关注者的id
    $follow_id = intval($row['follow_id']);

    $user_sql = "SELECT * FROM user WHERE id = '$follow_id' LIMIT 1";
    $user_query = $pdo_connect->query($user_sql);
    $user = $user_query->fetch();

    //用户信息
    $temp = array(
        'id' => intval($follow_id),
        'name' => $user ['name'],
        'avatar' => $user ['avatar'],
        'gender' => intval($user ['gender']),
        'sign' => $user ['sign'],
        'time' => strtotime($user['time'])
    );

    $result[$index] = $temp;
    $index ++;
}
echo json_encode($result);