<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/9/18
 * Time: 11:35
 *
 * 朋友圈子
 */

include '../base/connect_pdo.php';
include '../base/check.php';
include '../base/token.php';
include '../base/statusCode.php';
include '../base/header.php';

$headers = getallheaders();
$uid = get_UID($headers);

$page = $_POST["page"];  //从零开始
$page_num = $_POST["pageNum"];

if ($page_num == 0) {
    $page_num = 10;
}
$start = $page_num * $page;
$end = $page_num * ($page + 1);

//我关注的人的id收集
$sql = "SELECT follow_id FROM follow_relation WHERE requester_id = '$uid' ORDER BY time DESC";
$query = $pdo_connect->query($sql);
$rows = $query->fetchAll();

$ids = array();
//加上我的id == 朋友圈所有的id集合
$ids[0] = $uid;

$index = 1;

foreach ($rows as $row){

    //我关注的人的id
    $follow_id = intval($row['follow_id']);

    $ids[$index] = $follow_id;
    $index ++;
}

$index = 0;
$result = array();

foreach ($ids as $id){

    //收集每个人的话题
    $sql = "SELECT * FROM bbs WHERE author_id = '$id'";
    $query_result = $pdo_connect->query($sql);
    $rows = $query_result->fetchAll();

    foreach ($rows as $row) {

        $bbs_id = intval($row['id']);
        $author_id = $id;

        //作者信息
        $author_sql = "SELECT * FROM user WHERE id = '$author_id' LIMIT 1";
        $author_query = $pdo_connect->query($author_sql);
        $author = $author_query->fetch();

        //BBS评论条数
        $bbs_sql = "SELECT * FROM comment WHERE bbs_id='$bbs_id'";
        $bbs_query = $pdo_connect->query($bbs_sql);
        $comment_num = $bbs_query->rowCount();

        //BBS内容
        $temp['id'] = $bbs_id;
        $temp['authorId'] = $author_id;
        $temp['title'] = $row['title'];
        $temp['content'] = $row['content'];
        $temp['pictures'] = $row['pictures'];
        $temp['commentNum'] = $comment_num;
        $temp['time'] = strtotime($row['time']);
        //作者信息相关
        $temp['name'] = $author['name'];
        $temp['sign'] = $author['sign'];
        $temp['avatar'] = $author['avatar'];

        $result[$index] = $temp;
        $index ++;
    }

}

for($i = 0;$i < count($result) -1;$i ++){
    for($j = $i + 1; $j < count($result); $j ++){
        if($result[$i]['id'] < $result[$j]['id']){
            $temp = $result[$i];
            $result[$i] = $result[$j];
            $result[$j] = $temp;
        }
    }
}

echo json_encode(array_slice($result,$start,$page_num));