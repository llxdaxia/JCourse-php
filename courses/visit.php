<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/9/19
 * Time: 12:45
 */
include '../base/connect_pdo.php';

$id = $_POST['id'];

$star_sql = "UPDATE j_course SET visit_num = visit_num + 1 WHERE id = '$id' ";
$pdo_connect->exec($star_sql);

$result['info'] = "访问量+1";
echo json_encode($result);