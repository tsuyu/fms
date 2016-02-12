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

if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $exist = 0;
        $db = MySQL::getInstance();
        $db->autocommit(FALSE);

        if(!isset($key_stmt)) {
            $key_stmt = $db->prepare("SELECT 1 FROM `building_level_main` WHERE `blm_level_code`=? LIMIT 1");
        }
        $key_stmt->bind_param('s', $_POST['code']);
        $key_stmt->execute();
        $key_stmt->store_result();
        if($key_stmt->num_rows == 1) {
            $exist = 1;
        }else {

            $sql = "INSERT INTO `building_level_main`(`blm_level_code`, `blm_level_desc`, `blm_start`, `blm_end`,
            `blm_enter_by`, `blm_enter_date`)VALUES(?,?,?,?,?,?)";
            
            $stmt = $db->prepare($sql);
            $start = 0;
            $end = 0;
            $stmt->bind_param('ssiiss', $_POST['code'], $_POST['description'],$start,$end, $_SESSION['username'],
                    date('Y-m-d H:i:s'));
            $rc = $stmt->execute();
            $stmt->close();
        }
        $key_stmt->close();

        if($exist == 1) {
            $db->close();
            redirect("level_code_add.php?new=1","Data already exist!");
        }else if ( false===$rc ) {
            $db->rollback();
            $db->close();
            redirect("level_code_add.php?new=1","Failed!");
        }else {
            $db->commit();
            $db->close();
            redirect("level_code_add.php?new=1","Commit!");
        }
}else{
    redirect("level_code_add.php?new=1","Failed!");
}
?>