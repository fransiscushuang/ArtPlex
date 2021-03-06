<?php
$page = (isset($_POST['page'])) ? json_decode($_POST['page']) : 0;
$category_id = (isset($_POST['category_id'])) ? $_POST['category_id'] : "";
$keyword = (isset($_POST['title'])) ? $_POST['title'] : "";
$type = (isset($_POST['type'])) ? $_POST['type'] : null;
$access_time = (isset($_POST['access_time'])) ? $_POST['access_time'] : "";
$deleted_number = (isset($_POST['deleted_number'])) ? json_decode($_POST['deleted_number']) : 0;
include_once("../../vendor/autoload.php");
include_once("../helper.php");
include_once("../database.php");
include_once("../controller/Story/StoriesController.php");
$get_list_page = new StoriesController($conn, "", "", "", "", "", "", "");
if ($type === "all") echo json_encode($get_list_page->getListAllStories($page, $category_id, $keyword, $access_time, $deleted_number));
else if ($type === "publish") echo json_encode($get_list_page->getListPublishedStories($page, $category_id, $keyword, $type, $access_time, $deleted_number));
else if ($type === "unpublish") echo json_encode($get_list_page->getListUnpublishedStories($page, $keyword, $access_time, $deleted_number));
