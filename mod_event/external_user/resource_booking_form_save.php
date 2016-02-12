<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/
if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $location_id = sanitize($_POST['location_id']);
    $date_from = $_POST['year_from']."-".$_POST['month_from']."-".$_POST['day_from']." ".$_POST['timeh_from'].":".$_POST['timem_from'].":00";
    $date_to = $_POST['year_to']."-".$_POST['month_to']."-".$_POST['day_to']." ".$_POST['timeh_to'].":".$_POST['timem_to'].":00";
    $reason = sanitize($_POST['reason']);
    $status = "APPLY";

    //echo $date_from;

    $db = MySQL::getInstance();

    $key_stmt = $db->prepare("SELECT 1 FROM `event_booking_main` WHERE `ebm_location_id`= ?
            AND UNIX_TIMESTAMP(`ebm_from_date`) <= ? 
            AND UNIX_TIMESTAMP(`ebm_to_date`) >= ?
            LIMIT 1");
    $key_stmt->bind_param('iii', $location_id,strtotime($date_from),strtotime($date_to));
    $key_stmt->execute();
    $key_stmt->store_result();

    //echo strtotime(date($date_from))."-".strtotime(date($date_to));
    
    if($key_stmt->num_rows == 1) {
        $key_stmt->close();
        $db->close();
        redirect("home.php?mod=".encode('4')."&app=".encode('resource_booking_detail')."&id=".$location_id,"Failed!Resource already booked.");
    }else {
        $sql = "INSERT INTO `event_booking_main`(`ebm_location_id`,`ebm_from_date`,`ebm_to_date`,`ebm_purpose`,`ebm_requestor_id`,`ebm_status`,`ebm_enter_by`,`ebm_enter_date`)VALUES(?,?,?,?,?,?,?,?)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('isssssss', $location_id, $date_from, $date_to, $reason, $_SESSION['username'],$status, $_SESSION['username'], date('Y-m-d H:i:s'));
        $rc = $stmt->execute();
        $stmt->close();
        $key_stmt->close();
        if(false===$rc) {
            $db->close();
            redirect("home.php?mod=".encode('4')."&app=".encode('resource_booking_detail')."&id=".$location_id,"Failed!");
        }else {
            $db->close();
            redirect("home.php?mod=".encode('4')."&app=".encode('resource_booking_detail')."&id=".$location_id,"Commit!");
        }
    }
}else {
    redirect("home.php?mod=".encode('4')."&app=".encode('resource_booking_detail')."&id=".$location_id,"Failed!");
}
?>