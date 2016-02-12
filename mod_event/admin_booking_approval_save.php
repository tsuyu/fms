<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = sanitize($_POST['id']);
    $status = $_POST['status'];
    $note = $_POST['note'];

    //echo $date_from;

    $db = MySQL::getInstance();
    $sql = "UPDATE `event_booking_main` SET `ebm_status` = ?,`ebm_note` = ?,`ebm_update_by` = ?,`ebm_update_date` = ?  WHERE "
            . " ebm_seq_no = ? ";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('ssssi', $status, $note, $_SESSION['username'], date('Y-m-d H:i:s'), $id);
    $rc = $stmt->execute();
    $stmt->close();

    if (false === $rc) {
        $db->close();
        redirect("home.php?mod=" . encode('4') . "&app=" . encode('admin_booking_approval_detail')."&id=".$id, "Failed!");
    } else {
        $db->close();
        redirect("home.php?mod=" . encode('4') . "&app=" . encode('admin_booking_approval_detail')."&id=".$id, "Commit!");
    }
} else {
    redirect("home.php?mod=" . encode('4') . "&app=" . encode('admin_booking_approval_detail')."&id=".$id, "Failed!");
}
?>