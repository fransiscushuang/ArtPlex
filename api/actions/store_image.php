<?php
include_once("../../vendor/autoload.php");

include_once("../helper.php");
include_once("../database.php");

if (isset($_FILES["file"])) {
    //$nama_file = $_FILES["file"]["name"];
    $user_id = (isset($_POST["user_id"])) ? $_POST["user_id"] : null;
    $file_name = (isset($_POST["file_name"])) ? $_POST["file_name"] : null;

    $final_name = md5($file_name) . "." . explode(".", $_FILES['file']['name'])[1];
    //move_uploaded_file($_FILES["file"]["tmp_name"], "../../app/assets/temp-img/" . $final_name);
    try {
        $upload = $s3->upload($bucket, "temp-img/" .  $final_name, fopen($_FILES['file']['tmp_name'], 'rb'), 'public-read');
        echo json_encode(["success" => true, "error" => "", "url" => $upload->get('ObjectURL')]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
}
