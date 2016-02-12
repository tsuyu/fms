<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/
if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $batchno_day = sanitize($_POST['batchno_day']);
    $batchno_year = sanitize($_POST['batchno_year']);
    $batchno = $batchno_day."/".$batchno_year;
    $date_from = sanitize($_POST['year_from']."-".$_POST['month_from']."-".$_POST['day_from']);
    $date_to = sanitize($_POST['year_to']."-".$_POST['month_to']."-".$_POST['day_to']);
    $status = "NO";

    //echo $date_from;

    $rollback = FALSE;
    $db = MySQL::getInstance();
    $db->autocommit(FALSE);

    $key_stmt = $db->prepare("SELECT 1 FROM `utility_bill_main` WHERE `ubm_batch_no`= ? LIMIT 1");
    $key_stmt->bind_param('s', $batchno);
    $key_stmt->execute();
    $key_stmt->store_result();

    //echo strtotime(date($date_from))."-".strtotime(date($date_to));

    if($key_stmt->num_rows == 1) {
        $key_stmt->close();
        $db->close();
        redirect("home.php?mod=".encode('5')."&app=".encode('bill_grid'),"Failed! Batch already exist.");
    }else {
        $sql = "INSERT INTO `utility_bill_main`(`ubm_batch_no`,`ubm_from_date`,`ubm_to_date`,`ubm_process_status`,`ubm_enter_by`,`ubm_enter_date`)VALUES(?,?,?,?,?,?)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('ssssss', $batchno, $date_from, $date_to, $status, $_SESSION['username'], date('Y-m-d H:i:s'));
        $rc = $stmt->execute();
        $last_id = $stmt->insert_id;
        if ( false===$rc ) {
            $rollback = TRUE;
        }
        $stmt->close();

        $sql2 = "SELECT `lmd_code` FROM `location_main_detail` WHERE 1 AND `lmd_billing` = 'Y'";
        $stmt2 = $db->prepare($sql2);
        $stmt2->execute();
        $stmt2->bind_result($lmd_code);
        $columns = array();
        $i = 0;
        while ($stmt2->fetch()) {
            $columns[$i]['lmd_code'] = $lmd_code;
            $i++;
        }
        foreach ($columns as $array) {
            $lmd_code = $array['lmd_code'];
            $sql3 = "INSERT INTO `utility_bill_detail`(`ubd_main_seqno`,`ubd_location_code`,`ubd_enter_by`,`ubd_enter_date`)VALUES(?,?,?,?)";
            $stmt3 = $db->prepare($sql3);
            $stmt3->bind_param('isss', $last_id, $lmd_code, $_SESSION['username'], date('Y-m-d H:i:s'));
            $rc3 = $stmt3->execute();
            if ( false===$rc3 ) {
                $rollback = TRUE;
            }
            $stmt3->close();
        }
        $stmt2->close();
        $key_stmt->close();

        if ( TRUE===$rollback ) {
            $db->rollback();
            $db->close();
            redirect("home.php?mod=".encode('5')."&app=".encode('bill_grid'),"Failed!");
        }else {
            $db->commit();
            $db->close();
            redirect("home.php?mod=".encode('5')."&app=".encode('bill_grid'),"Commit!");
        }
    }
}else {
    $db->close();
    redirect("home.php?mod=".encode('5')."&app=".encode('bill_grid'),"Failed!");
}
?>
