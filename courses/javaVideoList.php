<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/9/14
 * Time: 9:28
 */
include '../base/check.php';
include '../base/connect_pdo.php';

$page = $_POST["page"];  //从零开始
$page_num = $_POST["pageNum"];

if ($page_num == 0) {
    $page_num = 10;
}
$start = $page_num * $page;
$end = $page_num * ($page + 1);

$sql = "SELECT * FROM j_video LIMIT $start,$page_num";
$query_result = $pdo_connect->query($sql);
$rows = $query_result->fetchAll();

$result = array();
$index = 0;
foreach ($rows as $row) {
    $temp['id'] = intval($row['id']);
    $temp['url'] = $row['url'];
    $temp['subtitle'] = $row['subtitle'];
    $temp['title'] = $row['title'];
    $temp['cover'] = $row['cover'];

    $result[$index] = $temp;
    $index ++;
}
echo json_encode($result);