<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/
if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = sanitize($_POST['txtid']);
    $obatchno = $_POST['txtobatchno'];
    $is_process = 0;
    //dumper($_POST);
    $db = MySQL::getInstance();
    $db->autocommit(FALSE);

    $key_stmt = $db->prepare("SELECT 1 FROM `utility_bill_main` WHERE `ubm_process_status` = 'YES'
        AND `ubm_seq_no`= ? LIMIT 1");
    $key_stmt->bind_param('i',$id);
    $key_stmt->execute();
    $key_stmt->store_result();

    if($key_stmt->num_rows == 1) {
        $is_process = 1;
    }

    $key_stmt->close();

    if($is_process == 1) {
        $db->close();
        redirect("home.php?mod=".encode('5')."&app=".encode('bill_grid_process')."&id=".$id,"Failed! This batch already process. ");
    }else {

        $sql = "SELECT `ubd_seq_no`,`lmd_code` FROM `location_main_detail`
            JOIN `utility_bill_detail` ON `lmd_code` = `ubd_location_code`
            JOIN `utility_bill_main` ON `ubd_main_seqno` = `ubm_seq_no`
            WHERE 1 AND `lmd_billing` = 'Y' AND `ubm_seq_no` = ?";

        $stmt = $db->prepare($sql);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $stmt->bind_result($ubd_seq_no,$lmd_code);

        $columns = array();
        $i = 0;
        while ($stmt->fetch()) {
            $columns[$i]['lmd_code'] = $lmd_code;
            $columns[$i]['ubd_seq_no'] = $ubd_seq_no;
            $i++;
        }
        $stmt->close();
        //dumper($columns);

        $sql_rate = "SELECT `ubr_electric_rate`,`ubr_water_rate` FROM `utility_bill_rates` LIMIT 1 ";

        $stmt_rate = $db->prepare($sql_rate);
        $stmt_rate->execute();
        $stmt_rate->bind_result($ubr_electric_rate,$ubr_water_rate);

        while ($stmt_rate->fetch()) {
            $electric = $ubr_electric_rate;
            $water = $ubr_water_rate;
        }
        $stmt_rate->close();

        $h = 0;
        $egtotal = 0.00;
        $wgtotal = 0.00;
        $gtotal = 0.00;

        foreach ($columns as $array) {

            $lmd_code = $array['lmd_code'];
            $ubd_seq_no = $array['ubd_seq_no'];
            
            $oemeter = $_POST['txtefmeter'][$ubd_seq_no][$lmd_code];
            $emeter = $_POST['txtetmeter'][$ubd_seq_no][$lmd_code];

            $owmeter = $_POST['txtwfmeter'][$ubd_seq_no][$lmd_code];
            $wmeter = $_POST['txtwtmeter'][$ubd_seq_no][$lmd_code];
            
            $eunit_total = ($emeter - $oemeter);
            $wunit_total = ($wmeter - $owmeter);

            $etotal = (($eunit_total) * $electric);
            $wtotal = (($wunit_total) * $water);
            $alltotal = $etotal + $wtotal;

            $sql3 = "UPDATE `utility_bill_detail` SET
                    `ubd_emeter_fread` = ?,
                    `ubd_wmeter_fread`= ?,
                    `ubd_emeter_tread` = ?,
                    `ubd_wmeter_tread`= ?,
                    `ubd_emeter_unit` = ?,
                    `ubd_wmeter_unit` = ?,
                    `ubd_etotal`= ?,
                    `ubd_wtotal`= ?,
                    `ubd_alltotal`= ?,
                    `ubd_update_by` = ?,
                    `ubd_update_date` = ?
                     WHERE `ubd_seq_no`= ?";
            $stmt3 = $db->prepare($sql3);
            $stmt3->bind_param('sisiiidddssi',
                    $emeter,
                    $wmeter,
                    $oemeter,
                    $owmeter,
                    $eunit_total,
                    $wunit_total,
                    $etotal,
                    $wtotal,
                    $alltotal,
                    $_SESSION['username'],
                    date('Y-m-d H:i:s'),
                    $ubd_seq_no);
            $rc3 = $stmt3->execute();
            if ( false===$rc3 ) {
                $rollback = TRUE;
            }
            $stmt3->close();

            $egtotal += $etotal;
            $wgtotal += $wtotal;
            $gtotal += $alltotal;
            $h++;
        }

        $status = "YES";
        $sql4 = "UPDATE `utility_bill_main` SET `ubm_obatch_no` = ?,`ubm_process_date`= ?,
             `ubm_process_status` = ?, `ubm_electric_total` = ?, ubm_water_total = ?, `ubm_grand_total` = ?,
             `ubm_update_by`= ?, `ubm_update_date`= ?
             WHERE `ubm_seq_no`= ?";
        $stmt4 = $db->prepare($sql4);
        $stmt4->bind_param('sssdddssi',$obatchno,date('Y-m-d H:i:s'),$status,$egtotal,$wgtotal,$gtotal,$_SESSION['username'], date('Y-m-d H:i:s'),$id);
        $rc4 = $stmt4->execute();

        if ( false===$rc4 ) {
            $rollback = TRUE;
        }
        $stmt4->close();

        if ( false===$rc ) {
            $db->rollback();
            $db->close();
            redirect("home.php?mod=".encode('5')."&app=".encode('bill_grid_process')."&id=".$id,"Failed!");
        }else {
            $db->commit();
            $db->close();
            redirect("home.php?mod=".encode('5')."&app=".encode('bill_grid_process')."&id=".$id,"Commit!");
        }
    }
}else {
    redirect("home.php?mod=".encode('5')."&app=".encode('bill_grid_process')."&id=".$id,"Failed!");
}
?>
