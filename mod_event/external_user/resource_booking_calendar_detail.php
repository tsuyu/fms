<?php
require_once '../../class.adapter.php';
require_once '../../include/helper.php';
require_once '../../session.php';

$session = new session();
$session->start_session('_s', false);

?>
<!doctype html><html  lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link rel="stylesheet" href="../../include/css/form.css" type="text/css" />
        <link rel="stylesheet" href="../../include/css/pure_table.css" type="text/css" />
        <link rel="stylesheet" href="../../include/css/buttons.css" type="text/css" />
    </head>
    <body>
        <?php
        $db = MySQL::getInstance();
        $sql = "SELECT DATE_FORMAT(`ebm_from_date`,'%d-%m-%Y'),TIME_FORMAT(`ebm_from_date`, '%h:%i%p'),DATE_FORMAT(`ebm_to_date`,'%d-%m-%Y'),TIME_FORMAT(`ebm_to_date`, '%h:%i%p'),`aum_name`, `ebm_purpose`,`ebm_status`
                FROM `event_booking_main` JOIN `apps_user_main` JOIN `location_main_detail` WHERE 1
                AND `aum_username` = `ebm_requestor_id` AND `ebm_location_id` = `lmd_seq_no` AND `ebm_seq_no` = ? ";
        $sql .=" ORDER BY `ebm_from_date` DESC ";
        $stmt = $db->prepare($sql);

        $stmt->bind_param("i", $_GET['id']);
        $stmt->execute();
        $stmt-> bind_result($ebm_from_date,$ebm_from_time,$ebm_to_date,$ebm_to_time,$aum_name,$ebm_purpose,$ebm_status);
        while ($stmt->fetch()) {
            ?>
        <table class="pure-table2" width="100%">
            <thead>
            </thead>
            <tbody>
                <tr class = "pure-table2-odd">
                    <td colspan="4"><b>Resource Booking Detail</b><input type="hidden" name="location_id" value="<?php echo $_GET['id'];?>"/></td>
                </tr>
                <tr>
                    <td width="20%" colspan="3" align="right">From (Date)</td>
                    <td><?php echo $ebm_from_date;?></td>
                </tr>
                <tr>
                    <td colspan="3" align="right">(Time)</td>
                    <td><?php echo $ebm_from_time;?></td>
                </tr>
                <tr>
                    <td colspan="4" align="right">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3" align="right">To (Date)</td>
                    <td><?php echo $ebm_to_date;?></td>
                </tr>
                <tr>
                    <td colspan="3" align="right">(Time)</td>
                    <td><?php echo $ebm_to_time;?></td>
                </tr>
                <tr>
                    <td colspan="3" align="right">Requested By</td>
                    <td><?php echo $aum_name;?></td>
                </tr>

                <tr>
                    <td colspan="3" align="right">&nbsp;</td>
                    <td colspan="3" align="left">
                        <button  onclick="return ns.back();" class="pure-button pure-button-primary_r" type="button" id="btnclose">Back</button>
                    </td>
                </tr>
            </tbody>
        </table>
            <?php } ?>
        <script type="text/javascript">
            var namespace;
            namespace = {
                back : function(){
                    location.href = "../external_user/resource_booking_calendar.php";
                }
            };
            window.ns = namespace;
        </script>

    </body>
</html>