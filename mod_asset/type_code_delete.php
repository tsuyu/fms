<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

require_once '../include/helper.php';
require_once '../class.adapter.php';

$id = decode($_GET['id']);

if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET) && isset($id)) {
    
    $db = MySQL::getInstance();
    $db->autocommit(FALSE);
    $sql = " DELETE FROM `asset_type_code` WHERE `atc_seq_no`= ? ";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('i',$id);
    $rc = $stmt->execute();
    $stmt->close();

    if ( false===$rc ) {
        $db->rollback();
        $db->close();
        redirect(ROOT."/home.php?mod=".encode("2")."&app=".encode("type_code_grid")."","Failed!");
    }else {
        $db->commit();
        $db->close();
        redirect(ROOT."/home.php?mod=".encode("2")."&app=".encode("type_code_grid")."","Commit!");
    }
}else {
    redirect(ROOT."/home.php?mod=".encode("2")."&app=".encode("type_code_grid")."","Failed!");
}
?>