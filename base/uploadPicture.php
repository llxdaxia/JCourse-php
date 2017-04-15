<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/7/10
 * Time: 15:06
 */

include 'connect_pdo.php';
include 'token.php';
include 'check.php';
include 'header.php';
include 'config.php';

$headers = getallheaders();
$id = get_UID($headers);
$token = get_token($headers);

check_token_past_due($token);

$uploads_dir = Config::$SERVICE_CACHE_IMAGE_DIR;
$root_image = "http://lemon95.cn/image/";
$width = $_POST['width'];
$height = $_POST['height'];

if ($_FILES['picture']['name'] != '') {
    $status_code = $_FILES['picture']['error'];
    if ($status_code > 0) {
        switch ($status_code) {
            case UPLOAD_ERR_INI_SIZE:
                $result = "上传的文件超过了 php.ini 中 upload_max_file_size 选项限制的值";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $result = "上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值";
                break;
            case UPLOAD_ERR_PARTIAL:
                $result = "文件只有部分被上传";
                break;
            case UPLOAD_ERR_NO_FILE:
                $result = "没有文件被上传";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $result = "找不到临时文件夹。PHP 4.3.10 和 PHP 5.0.3 引进";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $result = "文件写入失败。PHP 5.1.0 引进";
                break;
        }
    } else {

        $upload_result = move_uploaded_file($_FILES['picture']['tmp_name'], $uploads_dir . $_FILES['picture']['name']);
        $url = $root_image.$_FILES['picture']['name'];
        $sql = "INSERT INTO picture (url,width,height) VALUES ('$url','$width','$height')";

        $insert_pic = $pdo_connect->exec($sql);

        if ($upload_result && $insert_pic) {
            $result['info'] = "success";
        } else {
            $result['info'] = "failed";
        }
    }
} else {
    $result['info'] = "文件为空";
}

echo json_encode($result);