<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/9/19
 * Time: 14:33
 */
include '../base/config.php';
include '../base/connect_pdo.php';
include '../base/check.php';
include '../base/statusCode.php';

$sql = "select * from banner ORDER BY id LIMIT 5,10";
$query_result = $pdo_connect->query($sql);
$rows = $query_result->fetchAll();

$result = array();
$index = 0;
foreach ($rows as $row){
    $temp['id'] = $row['id'];
    $temp['title'] = $row['title'];
    $temp['imageUrl'] = $row['image_url'];
    $temp['webUrl'] = $row['web_url'];
    $result[$index] = $temp;
    $index++;
}
echo json_encode($result);