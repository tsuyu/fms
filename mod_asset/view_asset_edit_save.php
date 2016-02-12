<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/
$id = decode($_POST['seq_no']);
$id2 = decode($_POST['bar_no']);
$page = $_GET['page'];
$ipp = $_GET['ipp'];


if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $rollback = FALSE;
    $db = MySQL::getInstance();
    $db->autocommit(FALSE);

    if(isset($_POST['recordstatus']) && $_POST['recordstatus'] == "A") {
        if(!empty ($_POST['campus']) && !empty ($_POST['area']) && !empty ($_POST['building']) && !empty ($_POST['level']) &&
                !empty ($_POST['type']) && !empty ($_POST['system']) && !empty ($_POST['other'])) {

            if(!isset($key_stmt)) {
                $key_stmt = $db->prepare("SELECT 1 FROM `asset_running_code` WHERE `arc_status` = 'A' AND `arc_main_seqno`= ? ");
            }
            $key_stmt->bind_param('s',$id);
            $key_stmt->execute();
            $key_stmt->store_result();
            if($key_stmt->num_rows > 0) {
                $sql = "UPDATE `asset_running_code` SET `arc_status` = 'N' WHERE `arc_main_seqno`= ?";
                $stmt = $db->prepare($sql);
                $stmt->bind_param('s',$id);
                $rc = $stmt->execute();
                if ( false===$rc ) {
                    $rollback = TRUE;
                }
                $stmt->close();
            }

            $sql2 = "INSERT INTO `asset_running_code`(`arc_main_seqno`,`arc_start`,`arc_end`)VALUES(?,?,?)";
            $stmt2 = $db->prepare($sql2);
            $start = 15;
            $end = 18;
            $stmt2->bind_param('sii',$id,$start,$end);
            $rc2 = $stmt2->execute();
            $last_id = $stmt2->insert_id;
            if ( false===$rc2 ) {
                $rollback = TRUE;
            }
            $stmt2->close();

            
            $sql3 = "UPDATE `asset_main` SET `am_asset_desc` = ?,`am_tagging_status`=?,`am_update_by`= ?, `am_update_date`= ?
            WHERE `am_seq_no`= ?";
            $stmt3 = $db->prepare($sql3);

            $stmt3->bind_param('sssss', $_POST['description'],$_POST['taggingstatus'], $_SESSION['username'],
                    date('Y-m-d H:i:s'),$id);
            $rc3 = $stmt3->execute();
            if ( false===$rc3 ) {
                $rollback = TRUE;
            }

            $sql4 = "UPDATE `asset_barcode` SET `ab_campus_code` = ?,`ab_area_code`=?,`ab_building_code`=?,`ab_level_code`=?,`ab_type_code`=?,
            `ab_system_code`=?,`ab_other_code`=?,`ab_update_by`= ?, `ab_update_date`= ?,`ab_running_code` =?
            WHERE `ab_seq_no`= ? AND `ab_main_seqno`=? AND `ab_status`='A' ";
            $stmt4 = $db->prepare($sql4);
            $stmt4->bind_param('ssssssssssss', $_POST['campus'],$_POST['area'],$_POST['building'],$_POST['level'],$_POST['type'],$_POST['system'],
                    $_POST['other'], $_SESSION['username'],date('Y-m-d H:i:s'),$last_id,$id2,$id);
            $rc4 = $stmt4->execute();
            if ( false===$rc2 ) {
                $rollback = TRUE;
            }

            $sql5 = "SELECT concat(`cm_campus_code`,`arm_area_code`,`bm_building_code`,
                    `blm_level_code`,`atc_type_code`,`lm_code`,`lmd_code`,lpad(`arc_running_code`, 4, 0))
                    FROM `asset_barcode`
                    JOIN `campus_main` ON `cm_seq_no` = `ab_campus_code`
                    JOIN `area_main` ON `arm_seq_no` = `ab_area_code`
                    JOIN `building_main` ON `bm_seq_no` = `ab_building_code`
                    JOIN `building_level_main` ON `blm_seq_no` = `ab_level_code`
                    JOIN `asset_type_code` ON `atc_seq_no` = `ab_type_code`
                    JOIN `location_main` ON `lm_seq_no` = `ab_type_code`
                    JOIN `location_main_detail` ON `lmd_seq_no` = `ab_type_code`
                    JOIN `asset_running_code` ON `arc_running_code` = `ab_running_code`
                    WHERE `ab_status` = 'A' AND `arc_status` = 'A' AND `ab_main_seqno` = ?";

            $stmt5 = $db->prepare($sql5);
            $stmt5->bind_param("s", $id);
            $stmt5->execute();
            $stmt5->bind_result($barcode_no);
            $stmt5->fetch();
            if ( false===$rc5 ) {
                $rollback = TRUE;
            }
            $stmt5->close();

            $sql6 = "UPDATE `asset_main` SET `am_asset_no` = ? WHERE `am_seq_no`= ?";
            $stmt6 = $db->prepare($sql6);
            $stmt6->bind_param('ss',$barcode_no,$id);
            $rc6 = $stmt6->execute();
            if ( false===$rc6 ) {
                $rollback = TRUE;
            }
            $stmt6->close();


            if ( TRUE===$rollback ) {
                $db->rollback();
                $db->close();
                redirect("home.php?mod=".encode('2')."&app=".encode('view_asset_edit')."&id=".encode($id)."&page=".$page."&ipp=".$ipp,"Failed!");
            }else {
                $db->commit();
                $db->close();
                redirect("home.php?mod=".encode('2')."&app=".encode('view_asset_edit')."&id=".encode($id)."&page=".$page."&ipp=".$ipp,"Commit!");
            }

        }else {
            $db->close();
            redirect("home.php?mod=".encode('2')."&app=".encode('view_asset_edit')."&id=".encode($id)."&page=".$page."&ipp=".$ipp,"Cannot generate new barcode!");
        }
    }else {
        $sql = "UPDATE `asset_main` SET `am_asset_desc` = ?,`am_tagging_status`=?,`am_update_by`= ?, `am_update_date`= ?
            WHERE `am_seq_no`= ?";
        $stmt = $db->prepare($sql);

        $stmt->bind_param('sssss', $_POST['description'],$_POST['taggingstatus'], $_SESSION['username'],
                date('Y-m-d H:i:s'),$id);
        $rc = $stmt->execute();
        if ( false===$rc ) {
            $rollback = TRUE;
        }

        $sql2 = "UPDATE `asset_barcode` SET `ab_campus_code` = ?,`ab_area_code`=?,`ab_building_code`=?,`ab_level_code`=?,`ab_type_code`=?,
        `ab_system_code`=?,`ab_other_code`=?,`ab_update_by`= ?, `ab_update_date`= ?
            WHERE `ab_seq_no`= ? AND `ab_main_seqno`=? AND `ab_status`='A' ";
        $stmt2 = $db->prepare($sql2);
        $stmt2->bind_param('sssssssssss', $_POST['campus'],$_POST['area'],$_POST['building'],$_POST['level'],$_POST['type'],$_POST['system'],
                $_POST['other'], $_SESSION['username'],date('Y-m-d H:i:s'),$id2,$id);
        $rc2 = $stmt2->execute();
        if ( false===$rc2 ) {
            $rollback = TRUE;
        }

        $stmt->close();
        $stmt2->close();

        if ( TRUE===$rollback ) {
            $db->rollback();
            $db->close();
            redirect("home.php?mod=".encode('2')."&app=".encode('view_asset_edit')."&id=".encode($id)."&page=".$page."&ipp=".$ipp,"Failed!");
        }else {
            $db->commit();
            $db->close();
            redirect("home.php?mod=".encode('2')."&app=".encode('view_asset_edit')."&id=".encode($id)."&page=".$page."&ipp=".$ipp,"Commit!");
        }
    }
}else {
    redirect("home.php?mod=".encode('2')."&app=".encode('view_asset_edit')."&id=".encode($id)."&page=".$page."&ipp=".$ipp,"Failed!");
}
?>