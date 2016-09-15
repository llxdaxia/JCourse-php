<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/9/14
 * Time: 15:04
 */

include '../base/connect_pdo.php';
include '../base/check.php';
include '../base/config.php';
include '../base/header.php';

$page = $_POST["page"];  //从零开始
$page_num = $_POST["pageNum"];

if ($page_num == 0) {
    $page_num = 10;
}
$start = $page_num * $page;
$end = $page_num * ($page + 1);

$sql = "SELECT * FROM bbs LIMIT $start,$page_num";
$query_result = $pdo_connect->query($sql);
$rows = $query_result->fetchAll();

$result = array();
$index = 0;
foreach ($rows as $row) {

    $bbs_id = intval($row['id']);
    $author_id = intval($row['author_id']);

    //BBS内容
    $temp['pictures'] = $row['pictures'];
    $temp['content'] = $row['content'];
    $temp['title'] = $row['title'];

    $author_sql = "SELECT * FROM user WHERE id = '$author_id' LIMIT 1";
    $author_query = $pdo_connect->query($author_sql);
    $author = $author_query->fetch();

    //作者信息相关
    $temp['avatar'] = $author['avatar'];
    $temp['name'] = $author['name'];
    $temp['sign'] = $author['sign'];

    $result[$index] = $temp;
    $index ++;
}

echo json_encode($result);