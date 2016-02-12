<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

require_once '../include/helper.php';
require_once '../class.adapter.php';
require_once '../session.php';

$session = new session();
$session->start_session('_s', false);
$id = decode($_POST['seq_no']);


if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $db = MySQL::getInstance();
    $db->autocommit(FALSE);
    $sql = "UPDATE `utility_bill_rates` SET `ubr_electric_rate` = ?,`ubr_water_rate`= ?
            WHERE `ubr_seq_no`= ?";
    $stmt = $db->prepare($sql);

    $stmt->bind_param('ddi',$_POST['eunitrate'],$_POST['wunitrate'],$id);
    $rc = $stmt->execute();
    $stmt->close();

    if ( false===$rc ) {
        $db->rollback();
        $db->close();
        redirect("bill_grid_rate_edit.php?id=".encode($id),"Failed!");
    }else {
        $db->commit();
         $db->close();
        redirect("bill_grid_rate_edit.php?id=".encode($id),"Commit!");
    }
}else {
    redirect("bill_grid_rate_edit.php?id=".encode($id),"Failed!");
}
?>