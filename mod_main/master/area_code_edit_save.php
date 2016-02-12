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
    $sql = "UPDATE `area_main` SET `arm_area_desc` = ?,`arm_update_by`= ?, `arm_update_date`= ?
            WHERE `arm_seq_no`= ?";
    $stmt = $db->prepare($sql);

    $stmt->bind_param('ssss', $_POST['description'], $_SESSION['username'],
            date('Y-m-d H:i:s'),$id);
    $rc = $stmt->execute();
    $stmt->close();
    
    if ( false===$rc ) {
        $db->rollback();
        $db->close();
        redirect("area_code_edit.php?id=".encode($id),"Failed!");
    }else {
        $db->commit();
         $db->close();
        redirect("area_code_edit.php?id=".encode($id),"Commit!");
    }
}else {
    redirect("area_code_edit.php?id=".encode($id),"Failed!");
}
?>