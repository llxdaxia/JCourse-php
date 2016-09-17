<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/9/15
 * Time: 20:47
 */
include '../base/connect_pdo.php';
include '../base/check.php';
include '../base/config.php';
include '../base/header.php';

$bbs_id = $_POST['id'];

$sql = "SELECT * FROM bbs WHERE id='$bbs_id'";
$query_result = $pdo_connect->query($sql);
$row = $query_result->fetch();

//作者id
$author_id = intval($row['author_id']);

//作者相关信息查询
$author_sql = "SELECT * FROM user WHERE id = '$author_id' LIMIT 1";
$author_query = $pdo_connect->query($author_sql);
$author = $author_query->fetch();

$result['id'] = $bbs_id;
$result['authorId'] = $author_id;
$result['name'] = $author['name'];
$result['sign'] = $author['sign'];
$result['avatar'] = $author['avatar'];

//BBS内容
$result['title'] = $row['title'];
$result['content'] = $row['content'];
$result['pictures'] = $row['pictures'];
$result['time'] = strtotime($row['time']);

//bbs关系表查找
$bbs_sql = "SELECT * FROM bbs_comment_relation WHERE bbs_id='$bbs_id'";
$bbs_query = $pdo_connect->query($bbs_sql);
$bbses = $bbs_query->fetchAll();

//评论信息数组获取
$comments = array();
$comment_index = 0;
foreach ($bbses as $bbs) {

    $comment_id = $bbs['comment_id'];

    //评论内容
    $comment_sql = "SELECT * FROM comment WHERE id = '$comment_id' LIMIT 1";
    $comment_result = $pdo_connect->query($comment_sql);
    $comment = $comment_result->fetch();

    $comments[$comment_index]['content'] = $comment['content'];
    $commenter_id = $comment['commenter_id'];
    $object_id = intval($comment['object_id']);

    //评论者信息
    $commenter_sql = "SELECT * FROM user WHERE id = '$commenter_id' LIMIT 1";
    $commenter_query = $pdo_connect->query($commenter_sql);
    $commenter = $commenter_query->fetch();

    $comments[$comment_index]['name'] = $commenter['name'];
    $comments[$comment_index]['sign'] = $commenter['sign'];
    $comments[$comment_index]['avatar'] = $commenter['avatar'];

    //回复对象信息
    $object_sql = "SELECT * FROM user WHERE id = '$object_id' LIMIT 1";
    $object_query = $pdo_connect->query($object_sql);
    $object = $object_query->fetch();

    $comments[$comment_index]['objectId'] = $object_id;
    $comments[$comment_index]['objectName'] = $object['name'];
    $comment_index++;
}

//评论内容
$result['comments'] = $comments;

echo json_encode($result);