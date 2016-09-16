<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/9/16
 * Time: 22:32
 */
include '../base/connect_pdo.php';
include '../base/check.php';
include '../base/token.php';
include '../base/header.php';
include '../base/statusCode.php';

$id = $_POST['id'];

$sql = "SELECT * FROM bbs WHERE author_id = '$id' ORDER BY id DESC";
$query = $pdo_connect->query($sql);
$rows = $query->fetchAll();

$result = array();
$index = 0;
foreach ($rows as $row){

    $bbs_id = intval($row['id']);
    $author_id = intval($row['author_id']);

    $author_sql = "SELECT * FROM user WHERE id = '$author_id' LIMIT 1";
    $author_query = $pdo_connect->query($author_sql);
    $author = $author_query->fetch();

    //BBS内容
    $temp['id'] = $bbs_id;
    $temp['title'] = $row['title'];
    $temp['content'] = $row['content'];
    $temp['pictures'] = $row['pictures'];
    $temp['time'] = strtotime($row['time']);
    //作者信息相关
    $temp['name'] = $author['name'];
    $temp['sign'] = $author['sign'];
    $temp['avatar'] = $author['avatar'];

    $result[$index] = $temp;
    $index ++;
}
echo json_encode($result);