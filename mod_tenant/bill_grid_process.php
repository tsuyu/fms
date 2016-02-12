<div align="right">
    <button  onclick="return ns.back();" class="pure-button pure-button-primary_r" type="button" id="btnclose">Back</button>
</div><br/>
<form id="formread" action="">
    <input type="hidden" name="txtid" id="txtid" value="<?php echo sanitize($_GET['id']);?>">
    <input type="hidden" name="txtmode" id="txtmode" value="load">
    <?php
    //dumper($_POST);
    $bcode = bcode('utility_bill_main',MySQL::getInstance(),'ubm_seq_no','ubm_batch_no','ubm_batch_no','ubm_batch_no');
    $db = MySQL::getInstance();

    $stmt = $db->prepare("SELECT `ubm_batch_no`,`ubm_obatch_no`,DATE_FORMAT(`ubm_from_date`,'%d-%m-%Y'),DATE_FORMAT(`ubm_to_date`,'%d-%m-%Y'),`ubm_process_status`,`ubm_grand_total` FROM `utility_bill_main` WHERE `ubm_seq_no` = ? LIMIT 1");
    $stmt->bind_param("s", sanitize($_GET['id']));
    $stmt->execute();
    $stmt-> bind_result($ubm_batch_no,$ubm_obatch_no,$ubm_from_date,$ubm_to_date,$ubm_process_status,$ubm_grand_total);
    while ($stmt->fetch()) {
        if(isset($_POST['txtmode'])&& $_POST['txtmode']=='load') {
            $ubm_obatch_no = $_POST['slctobatchno'];
            $ubm_obatch_mapno = $_POST['slctobatchno'];
        }
        ?>
    <table class="pure-table2" width="100%">
        <thead>
        </thead>
        <tbody>
            <tr class = "pure-table2-odd">
                <td colspan="4"><b>Batch detail</b></td>
            </tr>
            <tr>
                <td width="30%" colspan="3" align="right">Current Batch No</td>
                <td><b><?php echo $ubm_batch_no;?></b>
                    <input type="hidden" name="txtbatchno" value="<?php echo $ubm_batch_no;?>"/>

                </td>
            </tr>
            <tr>
                <td width="30%" colspan="3" align="right">Compare Batch No</td>
                <td><select name="slctobatchno" id="slctobatchno">
                    <?php
                    $oldbatch  = "<option value=\"\">SELECT</option>\n";
                    //array($seq_no,$code,$desc);
                    for($i=0;$i<count($bcode);$i++) {
                        $oldbatch .= "<option value=\"".$bcode[$i][1]."\" ".selected($bcode[$i][1],$ubm_obatch_no)." >".$bcode[$i][2]."</option>\n";
                    }
                    echo $oldbatch;
                    ?>
                    </select></td>
            </tr>
            <tr>
                <td width="30%" colspan="3" align="right">Batch (From Date)</td>
                <td><b><?php echo $ubm_from_date;?></b></td>
            </tr>
            <tr>
                <td width="30%" colspan="3" align="right">Batch (To Date)</td>
                <td><b><?php echo $ubm_to_date;?></b></td>
            </tr>
            <tr>
                <td width="30%" colspan="3" align="right">Status</td>
                <td><?php echo $ubm_process_status;?></td>
            </tr>
            <tr>
                <td width="30%" colspan="3" align="right">Grand Total (RM)</td>
                <td><?php echo number_format($ubm_grand_total,2);?></td>
            </tr>
        </tbody>
    </table>
        <?php } ?>
    <br/>
</form>
<?php
if(isset($_POST['txtmode'])&& $_POST['txtmode']=='load') {
    $sql = "SELECT `ubd_location_code`, `ubd_emeter_tread`, `ubd_wmeter_tread` FROM `utility_bill_detail`
            JOIN `utility_bill_main` ON `ubd_main_seqno` = `ubm_seq_no`
            WHERE 1 AND `ubm_batch_no` = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s",$ubm_obatch_mapno);
    $stmt->execute();
    $stmt->bind_result($lmd_code,$ubd_emeter_tread,$ubd_wmeter_tread);
    $columns = array();
    while ($stmt->fetch()) {
        $columns[$lmd_code]['ubd_emeter_tread'] = $ubd_emeter_tread;
        $columns[$lmd_code]['ubd_wmeter_tread'] = $ubd_wmeter_tread;
    }
    $stmt->close();
}
?>
<form id="form1" action="">
    <input type="hidden" name="txtobatchno" value="<?php echo $ubm_obatch_mapno;?>"/>
    <input type="hidden" name="txtid" value="<?php echo sanitize($_GET['id']);?>"/>
    <table class="pure-table" width="100%">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Location</th>
                <th colspan="4">Electric</th>
                <th colspan="4">Water</th>
                <th>Total (RM)</th>
            </tr>
            <tr >
                <th></th>
                <th></th>
                <th width="15%"><b><?php echo $ubm_from_date;?></b></th>
                <th width="15%"><b><?php echo $ubm_to_date;?></b></th>
                <th width="10%">Units (kW)</th>
                <th width="7%">Total (RM)</th>
                <th width="15%"><b><?php echo $ubm_from_date;?></b></th>
                <th width="15%"><b><?php echo $ubm_to_date;?></b></th>
                <th width="10%">Units (Cubic Metre)</th>
                <th width="7%">Total (RM)</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $y = 1;
            $db = MySQL::getInstance();
            $etotal = 0.00;
            $wtotal = 0.00;
            $sql = "SELECT `ubd_seq_no`,`lmd_name`,`lmd_code`,`ubd_emeter_fread`,`ubd_emeter_tread`,`ubd_wmeter_fread`,`ubd_wmeter_tread`,
                    `ubd_emeter_unit`,`ubd_wmeter_unit`,`ubd_etotal`,`ubd_wtotal`,`ubd_alltotal`
                    FROM `location_main_detail`
                    JOIN `utility_bill_detail` ON `lmd_code` = `ubd_location_code`
                    JOIN `utility_bill_main` ON `ubd_main_seqno` = `ubm_seq_no`
                    WHERE 1 AND `lmd_billing` = 'Y' AND `ubm_seq_no` = ?";

            $stmt = $db->prepare($sql);
            $stmt->bind_param("s", $_GET['id']);
            $stmt->execute();
            $stmt->bind_result($ubd_seq_no,$lmd_name,$lmd_code,$ubd_emeter_fread,$ubd_emeter_tread,$ubd_wmeter_fread,$ubd_wmeter_tread,
                    $ubd_emeter_unit,$ubd_wmeter_unit,$ubd_etotal,$ubd_wtotal,$ubd_alltotal);
            while ($stmt->fetch()) {
                if ($y % 2 == 0) {
                    $odd = 'class = "pure-table-odd"';
                }else {
                    $odd = "";
                }
                ?>
            <tr <?php echo $odd;?>>
                <td><?php echo $y; ?></td>
                <td><b><?php echo output($lmd_name);?></b></td>
                <td><input type="text" id="txtefmeter<?php echo $y; ?>" name="txtefmeter[<?php echo $ubd_seq_no; ?>][<?php echo $lmd_code; ?>]"  
                   value="<?php
                       if(isset($_POST['txtmode'])&& $_POST['txtmode']=='load') {
                           echo $columns[$lmd_code]['ubd_emeter_tread'];
                       }else {
                           echo $ubd_emeter_fread;
                       }
                       ?>"
                   class="field-devided3"/>
                </td>
                <td><input type="text" id="txtetmeter<?php echo $y; ?>" name="txtetmeter[<?php echo $ubd_seq_no; ?>][<?php echo $lmd_code; ?>]"  value="<?php echo $ubd_emeter_tread; ?>" class="field-devided3"/></td>
                <td><?php echo output($ubd_emeter_unit);?></td>
                <td><?php echo number_format($ubd_etotal,2);?></td>
                <td><input type="text" id="txtwfmeter<?php echo $y; ?>" name="txtwfmeter[<?php echo $ubd_seq_no; ?>][<?php echo $lmd_code; ?>]"  
                   value="<?php
                       if(isset($_POST['txtmode'])&& $_POST['txtmode']=='load') {
                           echo $columns[$lmd_code]['ubd_wmeter_tread'];
                       }else {
                           echo $ubd_wmeter_fread;
                       }
                       ?>"
                   class="field-devided3"/>
                </td>
                <td><input type="text" id="txtwtmeter<?php echo $y; ?>" name="txtwtmeter[<?php echo $ubd_seq_no; ?>][<?php echo $lmd_code; ?>]"  value="<?php echo $ubd_wmeter_tread;?>" class="field-devided3"/></td>
                <td><?php echo output($ubd_wmeter_unit);?></td>
                <td><?php echo number_format($ubd_wtotal,2);?></td>
                <td><?php echo number_format($ubd_alltotal,2);?></td>
            </tr>
                <?php
                $etotal += $ubd_etotal;
                $wtotal += $ubd_wtotal;
                $y++;
            }
            $stmt->close();
            $db->close();
            ?>
            <tr>
                <td colspan="5">&nbsp;</td>
                <td><b><?php echo number_format($etotal,2);?></b></td>
                <td colspan="3">&nbsp;</td>
                <td><b><?php echo number_format($wtotal,2);?></b></td>
                <td align="right">
                    <button class="pure-button pure-button-primary" type="submit" id="btnsubmit">Submit</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>
<script type="text/javascript">

    var namespace;
    namespace = {
        back : function(id){
            location.href = "home.php?mod=v2&app=44m5c4d4d5e4l4i4a4";
        }
    };
    window.ns = namespace;

    //alert("Please select compare batch no !");

    $(document).ready(function(){

        $('#slctobatchno').change(function() {
            $("#formread").attr('action','home.php?mod=v2&app=44m5c4d4d5e4l4i4a4h5l4r4j46454x5o4&id='+$("#txtid").val());
            $("#formread").attr('method','post');
            $("#formread").submit();
        });

        $('#btnsubmit').click(function(event) {
            if ($('#slctobatchno').val() != ""){
                $("#form1").attr('action','home.php?mod=v2&app=44m5c4d4d5e4l4i4a4h5l4r4j46454x5o414q41436i5');
                $("#form1").attr('method','post');
                $("#form1").submit();
            }else{
                alert("Please select compare batch no !");
                return false;
            }
        });
    });
</script>