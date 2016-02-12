<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

require_once '../include/helper.php';
require_once '../class.adapter.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST)) {

    $rollback = FALSE;
    $db = MySQL::getInstance();
    $db->autocommit(FALSE);

    $none = 0;
    $checkbox = $_POST['checkbox'];
    $count = count($checkbox);

    //print_r($checkbox);

    if($count>0) {
        for($i = 0; $i < $count; $i++) {
            $id = decode($checkbox[$i]);

            $sql = " DELETE FROM `asset_main` WHERE `am_seq_no`= ? ";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('i',$id);
            $rc = $stmt->execute();
            if ( false===$rc ) {
                $rollback = TRUE;
            }

            $sql2 = " DELETE FROM `asset_barcode` WHERE `ab_main_seqno`= ? ";
            $stmt2 = $db->prepare($sql2);
            $stmt2->bind_param('i',$id);
            $rc2 = $stmt2->execute();
            if ( false===$rc2 ) {
                $rollback = TRUE;
            }

            $sql3 = " DELETE FROM `asset_running_code` WHERE `arc_main_seqno`= ? ";
            $stmt3 = $db->prepare($sql3);
            $stmt3->bind_param('i',$id);
            $rc3 = $stmt3->execute();
            if ( false===$rc3 ) {
                $rollback = TRUE;
            }
            $stmt->close();
            $stmt2->close();
            $stmt3->close();
        }
    }else {
        $none = 1;
    }


    if ( TRUE===$rollback ) {
        $db->rollback();
        $db->close();
        redirect(ROOT."/home.php?mod=".encode("2")."&app=".encode("view_asset_grid")."&page=".$_GET['page']."&ipp=".$_GET['ipp'],"Failed!");
    }else if($none == 1) {
        redirect(ROOT."/home.php?mod=".encode("2")."&app=".encode("view_asset_grid")."&page=".$_GET['page']."&ipp=".$_GET['ipp'],"Please choose one!");
    }else {
        $db->commit();
        $db->close();
        redirect(ROOT."/home.php?mod=".encode("2")."&app=".encode("view_asset_grid")."&page=".$_GET['page']."&ipp=".$_GET['ipp'],"Commit!");
    }
}else {
    redirect(ROOT."/home.php?mod=".encode("2")."&app=".encode("view_asset_grid")."&page=".$_GET['page']."&ipp=".$_GET['ipp'],"Failed!");
}
?>