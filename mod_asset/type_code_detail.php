<?php
header('P3P: CP="CAO PSA OUR"');
require_once '../include/helper.php';
require_once '../class.adapter.php';
//require_once '../session.php';
//$session = new session();
// Set to true if using https
//$session->start_session('_s', false);

$db = MySQL::getInstance();
$sql = "SELECT `atc_seq_no`, `atc_type_code`, `atc_type_desc`,
    `atc_start`, `atc_end`, `atc_enter_by`, `atc_enter_date`, `atc_update_by`, `atc_update_date`
    FROM `asset_type_code` WHERE `atc_seq_no` = ? LIMIT 1";

$stmt = $db->prepare($sql);
$stmt->bind_param("s", decode($_GET['id']));
$stmt->execute();
$stmt->bind_result($atc_seq_no,$atc_type_code,$atc_type_desc,$atc_start,$atc_end,
        $atc_enter_by,$atc_enter_date,$atc_update_by,$atc_update_date);
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
             var mainP = parent.document.getElementById('tcdwindow');
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
                    <th colspan="3">Type Code Detail</th>
                </tr>
            </thead>
            <tbody>
                <tr >
                    <td width="30%">Type Code</td>
                    <td width="5%">:</td>
                    <td><?php echo output($atc_type_code);?></td>
                </tr>
                <tr>
                    <td width="30%">Type Code Description</td>
                    <td width="5%">:</td>
                    <td><?php echo output($atc_type_desc);?></td>
                </tr>
                <tr>
                    <td width="30%">Type Start Position</td>
                    <td width="5%">:</td>
                    <td><?php echo output($atc_start);?></td>
                </tr>
                <tr>
                    <td width="30%">Type End Position</td>
                    <td width="5%">:</td>
                    <td><?php echo output($atc_end);?></td>
                </tr>
                <tr>
                    <td width="30%">Enter By</td>
                    <td width="5%">:</td>
                    <td><?php echo output($atc_enter_by);?></td>
                </tr>
                <tr>
                    <td width="30%">Enter Date</td>
                    <td width="5%">:</td>
                    <td><?php echo output($atc_enter_date);?></td>
                </tr>
                <tr>
                     <td width="30%">Update By</td>
                    <td width="5%">:</td>
                    <td><?php echo output($atc_update_by);?></td>
                </tr>
                <tr>
                    <td width="30%">Update Date</td>
                    <td width="5%">:</td>
                    <td><?php echo output($atc_update_date);?></td>
                </tr>
            </tbody>
        </table>
    </br>
        <div align="right">
         <button  onclick="return close();" class="pure-button pure-button-primary_r" type="button" id="btnclose">Close</button>
        </div>
    </body>
</html>