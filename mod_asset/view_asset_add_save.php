<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $rollback = FALSE;
    $exist = 0;
    $db = MySQL::getInstance();
    $db->autocommit(FALSE);

    if(!isset($key_stmt)) {
        $key_stmt = $db->prepare("SELECT 1 FROM `asset_main` WHERE `am_asset_no`=? LIMIT 1");
    }
    $key_stmt->bind_param('s', $_POST['assetno']);
    $key_stmt->execute();
    $key_stmt->store_result();
    if($key_stmt->num_rows == 1) {
        $exist = 1;
    }else if(isset($_POST['recordstatus']) && $_POST['recordstatus'] == "A") {
        if(!empty ($_POST['campus']) && !empty ($_POST['area']) && !empty ($_POST['building']) && !empty ($_POST['level']) &&
                !empty ($_POST['type']) && !empty ($_POST['system']) && !empty ($_POST['other'])) {

            $sql = "INSERT INTO `asset_main`(`am_asset_desc`,`am_enter_by`,`am_enter_date`)VALUES(?,?,?)";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('sss',$_POST['description'], $_SESSION['username'],date('Y-m-d H:i:s'));
            $rc = $stmt->execute();
            $last_id = $stmt->insert_id;
            if ( false===$rc ) {
                $rollback = TRUE;
            }
            $stmt->close();

            $sql2 = "INSERT INTO `asset_running_code`(`arc_main_seqno`,`arc_start`,`arc_end`)VALUES(?,?,?)";
            $stmt2 = $db->prepare($sql2);
            $start = 15;
            $end = 18;
            $stmt2->bind_param('sii',$last_id,$start,$end);
            $rc2 = $stmt2->execute();
            $last_id2 = $stmt2->insert_id;
            if ( false===$rc2 ) {
                $rollback = TRUE;
            }
            $stmt2->close();

            $sql3 = "INSERT INTO `asset_barcode`(`ab_main_seqno`,`ab_campus_code`,`ab_area_code`,`ab_building_code`,`ab_level_code`,
                `ab_type_code`,`ab_system_code`,`ab_other_code`,`ab_running_code`,`ab_enter_by`,`ab_enter_date`)
                 VALUES(?,?,?,?,?,?,?,?,?,?,?)";
            $stmt3 = $db->prepare($sql3);
            $stmt3->bind_param('sssssssssss',$last_id,$_POST['campus'],$_POST['area'],$_POST['building'],$_POST['level'],$_POST['type'],
                    $_POST['system'],$_POST['other'],$last_id2,$_SESSION['username'],date('Y-m-d H:i:s'));
            $rc3 = $stmt3->execute();
            if ( false===$rc3 ) {
                $rollback = TRUE;
            }
            $stmt3->close();

            $sql4 = "SELECT concat(`cm_campus_code`,`arm_area_code`,`bm_building_code`,
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

            $stmt4 = $db->prepare($sql4);
            $stmt4->bind_param("s", $last_id);
            $stmt4->execute();
            $stmt4->bind_result($barcode_no);
            $stmt4->fetch();
            if ( false===$rc4 ) {
                $rollback = TRUE;
            }
            $stmt4->close();

            $sql5 = "UPDATE `asset_main` SET `am_asset_no` = ? WHERE `am_seq_no`= ?";
            $stmt5 = $db->prepare($sql5);
            $stmt5->bind_param('ss',$barcode_no,$last_id);
            $rc5 = $stmt5->execute();
            if ( false===$rc5 ) {
                $rollback = TRUE;
            }
            $stmt5->close();
            
            if ( TRUE===$rollback ) {
                $db->rollback();
                $db->close();
                redirect("home.php?mod=".encode('2')."&app=".encode('view_asset_add'),"Failed!");
            }else {
                $db->commit();
                $db->close();
                redirect("home.php?mod=".encode('2')."&app=".encode('view_asset_add'),"Commit!");
            }
        }else {
            $db->close();
            redirect("home.php?mod=".encode('2')."&app=".encode('view_asset_add'),"Cannot generate new barcode!");
        }
    }else {

        $sql = "INSERT INTO `asset_main`(`am_asset_desc`,`am_enter_by`,`am_enter_date`)VALUES(?,?,?)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('sss',$_POST['description'], $_SESSION['username'],date('Y-m-d H:i:s'));
        $rc = $stmt->execute();
        $last_id = $stmt->insert_id;
        if ( false===$rc ) {
            $rollback = TRUE;
        }
        $stmt->close();

        $sql2 = "INSERT INTO `asset_barcode`(`ab_main_seqno`,`ab_campus_code`,`ab_area_code`,
                `ab_building_code`,`ab_level_code`,`ab_type_code`,`ab_system_code`,`ab_other_code`,`ab_enter_by`,`ab_enter_date`)
                VALUES(?,?,?,?,?,?,?,?,?,?)";
        $stmt2 = $db->prepare($sql2);
        $stmt2->bind_param('ssssssssss',$last_id,$_POST['campus'],$_POST['area'],$_POST['building'],$_POST['level'],$_POST['type'],
                $_POST['system'],$_POST['other'],$_SESSION['username'],date('Y-m-d H:i:s'));
        $rc2 = $stmt2->execute();
        if ( false===$rc2 ) {
            $rollback = TRUE;
        }
        $stmt2->close();
    }
    $key_stmt->close();
    $db->commit();

    if($exist == 1) {
        $db->close();
        redirect("home.php?mod=".encode('2')."&app=".encode('view_asset_add'),"Data already exist!");
    }else if ( TRUE===$rollback ) {
        $db->rollback();
        $db->close();
        redirect("home.php?mod=".encode('2')."&app=".encode('view_asset_add'),"Failed!");
    }else {
        $db->commit();
        $db->close();
        redirect("home.php?mod=".encode('2')."&app=".encode('view_asset_add')."&new=1","Commit!");
    }
}else {
    redirect("home.php?mod=".encode('2')."&app=".encode('view_asset_add'),"Failed!");
}
?>