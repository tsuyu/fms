<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

$id = sanitize($_GET['id']);

if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET) && isset($id)) {

    $rollback = FALSE;
    $db = MySQL::getInstance();
    $db->autocommit(FALSE);

    $sql = " DELETE FROM `utility_bill_main` WHERE `ubm_seq_no`= ? ";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('i',$id);
    $rc = $stmt->execute();
    if ( false===$rc ) {
        $rollback = TRUE;
    }

    $sql2 = " DELETE FROM `utility_bill_detail` WHERE `ubd_main_seqno`= ? ";
    $stmt2 = $db->prepare($sql2);
    $stmt2->bind_param('i',$id);
    $rc2 = $stmt2->execute();
    if ( false===$rc2 ) {
        $rollback = TRUE;
    }

    $stmt->close();
    $stmt2->close();

    if ( TRUE===$rollback ) {
        $db->rollback();
        $db->close();
        redirect("home.php?mod=".encode('5')."&app=".encode('bill_grid'),"Failed!");
    }else {
        $db->commit();
        $db->close();
        redirect("home.php?mod=".encode('5')."&app=".encode('bill_grid'),"Commit!");
    }
}else {
    redirect("home.php?mod=".encode('5')."&app=".encode('bill_grid'),"Failed!");
}
?>