<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/8/13
 * Time: 19:04
 */
include '../base/connect_pdo.php';
include '../base/token.php';
include '../base/check.php';
include '../base/header.php';
include '../base/config.php';
include '../base/statusCode.php';

$headers = getallheaders();
$uid = get_UID($headers);
$token = get_token($headers);

check_token_past_due($token);

$id = $_POST['id'];

$check_sql = "SELECT * FROM j_course_relation WHERE user_id = '$uid' AND j_course_id = '$id'";
$check_result = $pdo_connect->query($check_sql);
if($check_result->rowCount() == 0){
    $current_time = date("Y-m-d H:i:s");
    $sql = "INSERT INTO j_course_relation (user_id,j_course_id,time) VALUES ('$uid','$id','$current_time')";
    $insert_result = $pdo_connect->exec($sql);
    if($insert_result > 0){
        $result['info'] = "收藏成功";

        $star_sql = "UPDATE j_course SET star_num = star_num + 1 WHERE id = '$id' ";
        $pdo_connect->exec($star_sql);
    }else{
        serverError();
    }
}else{
    $result['info'] = "已收藏";
}
echo json_encode($result);
