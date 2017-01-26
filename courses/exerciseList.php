<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2017.1.22
 * Time: 20:17
 */
include '../base/check.php';
include '../base/connect_pdo.php';

$exercise_id = $_POST['id'];

$sql = "select * from j_exercise WHERE course_id = '$exercise_id'";

$query_result = $pdo_connect->query($sql);
$rows = $query_result->fetchAll();

$result = array();
$index = 0;
foreach ($rows as $row) {
    $temp['id'] = intval($row['id']);
    $temp['courseId'] = intval($row['course_id']);
    $temp['title'] = $row['title'];
    $temp['isMultipleChoice'] = intval($row['is_multiple_choice']);
    $temp['contentList'] = $row['content_list'];
    $temp['answer'] = $row['answer'];

    $result[$index] = $temp;
    $index++;
}
echo json_encode($result);
