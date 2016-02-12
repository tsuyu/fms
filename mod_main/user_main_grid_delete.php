<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

$id = decode($_GET['id']);

if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET) && isset($id)) {

    $rollback = FALSE;
    $db = MySQL::getInstance();
    $db->autocommit(FALSE);

    $sql = " DELETE FROM `apps_user_main` WHERE `aum_seq_no`= ? ";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('i',$id);
    $rc = $stmt->execute();
    if ( false===$rc ) {
        $rollback = TRUE;
    }
    
    $stmt->close();

    if ( TRUE===$rollback ) {
        $db->rollback();
        $db->close();
        redirect("home.php?mod=".encode("1")."&app=".encode("user_main_grid")."&page=".$_GET['page']."&ipp=".$_GET['ipp'],"Failed!");
    }else {
        $db->commit();
        $db->close();
        redirect("home.php?mod=".encode("1")."&app=".encode("user_main_grid")."&page=".$_GET['page']."&ipp=".$_GET['ipp'],"Commit!");
    }
}else {
    redirect("home.php?mod=".encode("1")."&app=".encode("user_main_grid")."&page=".$_GET['page']."&ipp=".$_GET['ipp'],"Failed!");
}
?>
