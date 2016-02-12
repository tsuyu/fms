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

if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $exist = 0;
        $db = MySQL::getInstance();
        $db->autocommit(FALSE);

        if(!isset($key_stmt)) {
            $key_stmt = $db->prepare("SELECT 1 FROM `location_main_detail` WHERE `lmd_code`=? LIMIT 1");
        }
        $key_stmt->bind_param('s', $_POST['code']);
        $key_stmt->execute();
        $key_stmt->store_result();
        if($key_stmt->num_rows == 1) {
            $exist = 1;
        }else {

            $sql = "INSERT INTO `location_main_detail`(
                `lmd_code`,
                `lmd_main_code`,
                `lmd_name`,
                `lmd_desc`,
                `lmd_capacity`,
                `lmd_status`,
                `lmd_billing`,
                `lmd_booking`,
                `lmd_start`,
                `lmd_end`,
                `lmd_enter_by`,
                `lmd_enter_date`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
            
            $stmt = $db->prepare($sql);
            $start = 11;
            $end = 14;
            $stmt->bind_param('ssssssssssss', $_POST['code'], $_POST['location_main'],$_POST['name'],$_POST['description'],
                    $_POST['capacity'],$_POST['status'],$_POST['billing'],$_POST['booking'],
                    $start,$end, $_SESSION['username'],date('Y-m-d H:i:s'));
            $rc = $stmt->execute();
            $stmt->close();
        }
        $key_stmt->close();

        if($exist == 1) {
            $db->close();
            redirect("location_code_add.php?new=1","Data already exist!");
        }else if ( false===$rc ) {
            $db->rollback();
            $db->close();
            redirect("location_code_add.php?new=1","Failed!");
        }else {
            $db->commit();
            $db->close();
            redirect("location_code_add.php?new=1","Commit!");
        }
}else{
    redirect("other_code_add.php?new=1","Failed!");
}
?>