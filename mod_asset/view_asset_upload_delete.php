<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

$id = $_GET['id'];
$fid = decode($_GET['fid']);
$fname = decode($_GET['fname']);

if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET) && isset($id)) {

    $rollback = FALSE;
    $db = MySQL::getInstance();
    $db->autocommit(FALSE);

    $sql = " DELETE FROM `asset_photos` WHERE `ap_seq_no`= ? ";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('i',$fid);
    $rc = $stmt->execute();
    if ( false===$rc ) {
        $rollback = TRUE;
    }
    $stmt->close();

    if ( TRUE===$rollback ) {
        $db->rollback();
        $db->close();
        redirect("home.php?mod=".encode("2")."&app=".encode("view_asset_edit")."&id=".$id."&page=".$_GET['page']."&ipp=".$_GET['ipp'],"Failed!");
    }else {
        $db->commit();
        $db->close();
        $file = "uploads/asset/".decode($id)."/".$fname;
        if (!unlink($file)){
          redirect("home.php?mod=".encode("2")."&app=".encode("view_asset_edit")."&id=".$id."&page=".$_GET['page']."&ipp=".$_GET['ipp'],"Failed!");
        } else{
          redirect("home.php?mod=".encode("2")."&app=".encode("view_asset_edit")."&id=".$id."&page=".$_GET['page']."&ipp=".$_GET['ipp'],"Commit!");
        }
    }
}else {
    redirect("home.php?mod=".encode("2")."&app=".encode("view_asset_edit")."&id=".$id."&page=".$_GET['page']."&ipp=".$_GET['ipp'],"Failed!");
}
?>