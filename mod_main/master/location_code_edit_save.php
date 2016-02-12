<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

require_once '../../include/helper.php';
require_once '../../class.adapter.php';
require_once '../../session.php';

$session = new session();
$session->start_session('_s', false);
$id = decode($_POST['seq_no']);


if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $db = MySQL::getInstance();
    $db->autocommit(FALSE);
    $sql = "UPDATE `location_main_detail` SET
        `lmd_code` = ?,
        `lmd_main_code`  = ?,
        `lmd_name` = ?,
        `lmd_desc` = ?,
        `lmd_capacity` = ?,
        `lmd_status` = ?,
        `lmd_billing` = ?,
        `lmd_booking` = ?,
        `lmd_update_by`= ?,
        `lmd_update_date`= ?
        WHERE `lmd_seq_no`= ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('ssssssssssi',  $_POST['code'], $_POST['location_main'],$_POST['name'],$_POST['description'],
            $_POST['capacity'],$_POST['status'],$_POST['billing'],$_POST['booking'], $_SESSION['username'],
            date('Y-m-d H:i:s'),$id);
    $rc = $stmt->execute();
    $stmt->close();

    if ( false===$rc ) {
        $db->rollback();
        $db->close();
        redirect("location_code_edit.php?id=".encode($id),"Failed!");
    }else {
        $db->commit();
        $db->close();
        redirect("location_code_edit.php?id=".encode($id),"Commit!");
    }
}else {
    redirect("location_code_edit.php?id=".encode($id),"Failed!");
}
?>