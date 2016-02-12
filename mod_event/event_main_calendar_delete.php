<?php
header('Content-Type: application/json');
require_once '../class.adapter.php';
require_once '../include/helper.php';
require_once '../session.php';

$session = new session();
$session->start_session('_s', false);

$id = $_POST['id'];

$db = MySQL::getInstance();
$sql = " DELETE FROM `event_calendar` WHERE `ec_seq_no`= ? ";
$stmt = $db->prepare($sql);
$stmt->bind_param('i',$id);
$rc = $stmt->execute();
$stmt->close();

if(false===$rc) {
    echo json_encode(array("status"=>"failed"));
}else {
    echo json_encode(array("status"=>"commit"));
}
?>
