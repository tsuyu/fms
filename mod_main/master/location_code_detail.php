<?php
header('P3P: CP="CAO PSA OUR"');
require_once '../../include/helper.php';
require_once '../../class.adapter.php';
//require_once '../session.php';
//$session = new session();
// Set to true if using https
//$session->start_session('_s', false);

$db = MySQL::getInstance();
$sql = "SELECT `lmd_seq_no`,`lm_name`, `lmd_code`,`lmd_name`,`lmd_desc`,`lmd_capacity`,`lmd_status`,
        `lmd_start`,`lmd_end`,`lmd_billing`, `lmd_booking`,`lmd_enter_by`,`lmd_enter_date`,`lmd_update_by`,`lmd_update_date` FROM `location_main_detail`
        JOIN `location_main` WHERE 1 AND `lmd_main_code` = `lm_code` AND `lmd_seq_no` = ? LIMIT 1";

$stmt = $db->prepare($sql);
$stmt->bind_param("s", decode($_GET['id']));
$stmt->execute();
$stmt->bind_result($lmd_seq_no,$lm_name,$lmd_code,$lmd_name,$lmd_desc,$lmd_capacity,
        $lmd_status,$lmd_start,$lmd_end,$lmd_billing,$lmd_booking,$lmd_enter_by,$lmd_enter_date,$lmd_update_by,$lmd_update_date);
$stmt->fetch();
$stmt->close();
$db->close();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <link href="../../include/css/pure_table.css" rel='stylesheet' type='text/css' />
        <link href="../../include/css/buttons.css" rel='stylesheet' type='text/css' />
        <script type="text/javascript" src="../../include/js/jquery.min.js"></script>
        <script type="text/javascript" language="javascript">
    $(document).ready(function(){

        $("#btnclose").click( function(){
             var mainP = parent.document.getElementById('ocdwindow');
             mainP.close();
           }
        );
});


</script>
    </head>
    <body>
        <table class="pure-table" width="100%">
            <thead>
                <tr >
                    <th colspan="3">Location Detail</th>
                </tr>
            </thead>
            <tbody>
                <tr >
                    <td width="30%">Code</td>
                    <td width="5%">:</td>
                    <td><?php echo output($lmd_code);?></td>
                </tr>
                 <tr >
                    <td width="30%">Name</td>
                    <td width="5%">:</td>
                    <td><?php echo output($lmd_name);?></td>
                </tr>
                <tr>
                    <td width="30%">Description</td>
                    <td width="5%">:</td>
                    <td><?php echo output($lmd_desc);?></td>
                </tr>
                <tr>
                    <td width="30%">Category</td>
                    <td width="5%">:</td>
                    <td><?php echo output($lm_name);?></td>
                </tr>
                <tr>
                    <td width="30%">Capacity</td>
                    <td width="5%">:</td>
                    <td><?php echo output($lmd_capacity);?></td>
                </tr>
                <tr>
                    <td width="30%">Status</td>
                    <td width="5%">:</td>
                    <td><?php echo output($lmd_status);?></td>
                </tr>
                <tr>
                    <td width="30%">Billing</td>
                    <td width="5%">:</td>
                    <td><?php echo output($lmd_billing);?></td>
                </tr>
                <tr>
                    <td width="30%">Booking</td>
                    <td width="5%">:</td>
                    <td><?php echo output($lmd_booking);?></td>
                </tr>
                <tr>
                    <td width="30%">Start Position</td>
                    <td width="5%">:</td>
                    <td><?php echo output($lmd_start);?></td>
                </tr>
                <tr>
                    <td width="30%">End Position</td>
                    <td width="5%">:</td>
                    <td><?php echo output($lmd_end);?></td>
                </tr>
                <tr>
                    <td width="30%">Enter By</td>
                    <td width="5%">:</td>
                    <td><?php echo output($lmd_enter_by);?></td>
                </tr>
                <tr>
                    <td width="30%">Enter Date</td>
                    <td width="5%">:</td>
                    <td><?php echo output($lmd_enter_date);?></td>
                </tr>
                <tr>
                     <td width="30%">Update By</td>
                    <td width="5%">:</td>
                    <td><?php echo output($lmd_update_by);?></td>
                </tr>
                <tr>
                    <td width="30%">Update Date</td>
                    <td width="5%">:</td>
                    <td><?php echo output($lmd_update_date);?></td>
                </tr>
            </tbody>
        </table>
    </br>
        <div align="right">
         <button  onclick="return close();" class="pure-button pure-button-primary_r" type="button" id="btnclose">Close</button>
        </div>
    </body>
</html>