<?php
header('Content-Type: application/json');
require_once '../class.adapter.php';
require_once '../include/helper.php';
require_once '../session.php';

$session = new session();
$session->start_session('_s', false);

$title = $_POST['title'];
$start = date("Y-m-d H:i:s",$_POST['start']);
$end = date("Y-m-d H:i:s",$_POST['end']);
$allDay = $_POST['allDay'];

$db = MySQL::getInstance();

$sql = "INSERT INTO `event_calendar`(`ec_title`,`ec_startdate`,`ec_enddate`,`ec_enter_by`,`ec_enter_date`,`ec_all_day`)VALUES(?,?,?,?,?,?)";
$stmt = $db->prepare($sql);
$stmt->bind_param('ssssss', $title, $start, $end, $_SESSION['username'], date('Y-m-d H:i:s'),$allDay);
$rc = $stmt->execute();
$stmt->close();

if(false===$rc) {
    echo json_encode(array("status"=>"failed"));
}else {
    echo json_encode(array("status"=>"commit"));
}
?>