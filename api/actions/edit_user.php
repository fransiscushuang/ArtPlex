<?php
$user_id = (isset($_POST['user_id'])) ? $_POST['user_id'] : null;
$name = (isset($_POST['name'])) ? $_POST['name'] : null; //
$status = (isset($_POST['name'])) ? $_POST['name'] : null; //
$level = (isset($_POST['name'])) ? $_POST['name'] : null; //

include_once("../../vendor/autoload.php");
include_once("../helper.php");
include_once("../database.php");
include_once("../controller/User/UsersController.php");


$user = new UsersController($conn, $user_id = "", $name, $status, $level, "", "", "",  "", "");
echo json_encode($user->editUser());
