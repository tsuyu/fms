<?php
$db = MySQL::getInstance();
$sql = "SELECT DATE_FORMAT(`ebm_from_date`,'%d-%m-%Y'),TIME_FORMAT(`ebm_from_date`, '%h:%i%p'),DATE_FORMAT(`ebm_to_date`,'%d-%m-%Y'),TIME_FORMAT(`ebm_to_date`, '%h:%i%p'),`aum_name`, 
        `ebm_purpose`,`ebm_status`,`ebm_seq_no`, `ebm_requestor_id`,`ebm_note`
        FROM `event_booking_main` JOIN `apps_user_main` JOIN `location_main_detail` WHERE 1
        AND `ebm_location_id` = `lmd_seq_no` AND ebm_seq_no = ? ORDER BY `ebm_from_date` DESC ";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", sanitize($_GET['id']));
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($ebm_from_date, $ebm_from_time, $ebm_to_date, $ebm_to_time, $aum_name, $ebm_purpose, $ebm_status, $ebm_seq_no, $ebm_requestor_id, $ebm_note);
$stmt->fetch();
$stmt->close();
?>
<form id="form2" action="" class="form-style-1">
    <input type="hidden" name="id" value="<?php echo $ebm_seq_no; ?>" />
    <table class="pure-table2" width="100%" >
        <thead>
        </thead>
        <tbody>
            <?php
            //echo encode("resource_booking_form_save");
            $stmt2 = $db->prepare("SELECT `aum_username`,`aum_name`,`aum_email`, `aum_phone` FROM `apps_user_main`
                WHERE 1 AND `aum_username` = ? ");
            $stmt2->bind_param("s", $ebm_requestor_id);
            $stmt2->execute();
            $stmt2->bind_result($aum_username, $aum_name, $aum_email, $aum_phone);
            while ($stmt2->fetch()) {
                ?>
                <tr class = "pure-table2-odd">
                    <td colspan="2"><b>Requestor Details</b></td>
                </tr>
                <tr>
                    <td width="15%">ID-Name</td>
                    <td><?php echo $aum_username . "-" . $aum_name; ?></td>
                </tr>
                <tr>
                    <td width="15%">Phone No</td>
                    <td><?php echo $aum_phone; ?></td>
                </tr>
                <tr>
                    <td width="15%">Email</td>
                    <td><?php echo $aum_email; ?></td>
                </tr>
                <?php
            }
            $stmt2->close();
            ?>
        </tbody>
    </table>
    <br/>
    <table class="pure-table2" width="100%">
        <thead>
        </thead>
        <tbody>
            <tr class = "pure-table2-odd">
                <td colspan="2"><b>Booking Details</b></td>
            </tr>
            <tr>
                <td width="15%">Date</td>
                <td><?php echo $ebm_from_date; ?> <b>to</b> <?php echo $ebm_to_date; ?></td>
            </tr>
            <tr>
                <td width="15%">Time</td>
                <td><?php echo $ebm_from_time; ?> <b>to</b> <?php echo $ebm_to_time; ?> </td>
            </tr>
            <tr>
                <td width="15%">Status</td>
                <td><?php echo $ebm_status; ?></td>
            </tr>
            <tr>
                <td width="15%">Purpose</td>
                <td><?php echo $ebm_purpose; ?></td>
            </tr>
        </tbody>
    </table>
    <br/>
    <table class="pure-table2" width="100%">
        <thead>
        </thead>
        <tbody>
            <tr class = "pure-table2-odd">
                <td colspan="2"><b>Admin Approval</b></td>
            </tr>
            <tr>
                <td width="15%">Approval Status</td>
                <td><select name="status">
                        <?php if($ebm_status == 'APPLY'){?>
                            <option value="APPLY" selected="selected">APPLY</option>
                            <option value="APPROVE">APPROVE</option>
                            <option value="REJECT">REJECT</option>
                        <?php }else if($ebm_status == 'APPROVE'){?>
                            <option>Select</option>
                            <option value="APPLY">APPLY</option>
                            <option value="APPROVE" selected="selected">APPROVE</option>
                            <option value="REJECT">REJECT</option>
                        <?php }else if($ebm_status == 'REJECT'){?>
                            <option>Select</option>
                            <option value="APPLY">APPLY</option>
                            <option value="APPROVE">APPROVE</option>
                            <option value="REJECT" selected="selected">REJECT</option>
                        <?php }?>
                    </select></td>
            </tr>
            <tr>
                <td width="15%">Note</td>
                <td>
                    <textarea rows="4" cols="50" name="note" class="field-textarea"><?php echo $ebm_note; ?></textarea>
                </td>
            </tr>
            <tr>
                <td width="15%"></td>
                <td>
                    <button name="btnsubmit" class="pure-button pure-button-primary_g" onclick="ns.approve(<?php echo $ebm_seq_no; ?>); return false" type="button" id="btnsubmit">Submit</button>
                    <button  onclick="return ns.back(<?php echo $_GET['id']; ?>);" class="pure-button pure-button-primary_r" type="button" id="btnclose">Back</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>   
<br/>
<?php
$db->close();
?>
<script type="text/javascript">
    var namespace;
    namespace = {
        reset: function () {
            location.href = "home.php?mod=u2&app=k4i5j4g4z5p464e454k5k4o4f4c4e4l544l4r41416y516";
        },
        back: function () {
            location.href = "home.php?mod=u2&app=34h5d4a4s56454o4l4t5e4n4b42414u5l4k4m4m4i5p5";
        }
    };
    window.ns = namespace;

    $(document).ready(function () {

        $('#btnsubmit').click(function (event) {
            $("#form2").attr('action', 'home.php?mod=u2&app=34h5d4a4s56454o4l4t5e4n4b42414u5l4k4m4m4i5p5h5z56436e4');
            $("#form2").attr('method', 'post');
            $("#form2").submit();
        });
    });

</script>
