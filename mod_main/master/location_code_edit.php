<?php
header('P3P: CP="CAO PSA OUR"');
require_once '../../include/util/class.util.php';
require_once '../../include/helper.php';
require_once '../../class.adapter.php';
//require_once '../session.php';
//$session = new session();
// Set to true if using https
//$session->start_session('_s', false);

$scode = bcode('location_main',MySQL::getInstance(),'lm_seq_no','lm_code','lm_name');

$db = MySQL::getInstance();
$stmt = $db->prepare("SELECT `lmd_seq_no`,
                `lmd_code`,
                `lmd_main_code`,
                `lmd_name`,
                `lmd_desc`,
                `lmd_capacity`,
                `lmd_status`,
                `lmd_billing`,
                `lmd_booking`
    FROM `location_main_detail` WHERE `lmd_seq_no` = ? LIMIT 1");
$stmt->bind_param("s", decode($_GET['id']));
$stmt->execute();
$stmt->bind_result($lmd_seq_no,$lmd_code,$lmd_main_code,$lmd_name,$lmd_desc,$lmd_capacity,$lmd_status,$lmd_billing,$lmd_booking);
$stmt->fetch();
$stmt->close();
$db->close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <link href="../../include/css/form.css" rel='stylesheet' type='text/css' />
        <link href="../../include/css/buttons.css" rel='stylesheet' type='text/css' />
        <script type="text/javascript" src="../../include/js/jquery.min.js"></script>
        <script type="text/javascript" src="../../include/js/validation.js"></script>
        <script type="text/javascript" language="javascript">
            $(document).ready(function(){
                $('#btnsubmit').click(function(event) {

                    var error_msg  = [];
                    $('#txtcode').validator({
                        fieldLabel : '- Code',
                        invalidEmpty: true,
                        noSpaceFirstLast: true,
                        format: 'numeric',
                        error: function(stat,type,msg) {
                            error_msg.push(msg.message);
                        }
                    });

                    $('#txtname').validator({
                        fieldLabel : '- Name',
                        invalidEmpty: true,
                        noSpaceFirstLast: true,
                        error: function(stat,type,msg) {
                            error_msg.push(msg.message);
                        }
                    });

                    $('#txtdescription').validator({
                        fieldLabel : '- Description',
                        invalidEmpty: true,
                        noSpaceFirstLast: true,
                        error: function(stat,type,msg) {
                            error_msg.push(msg.message);
                        }
                    });

                    $('#txtcapacity').validator({
                        fieldLabel : '- Capacity',
                        invalidEmpty: true,
                        noSpaceFirstLast: true,
                        format: 'numeric',
                        error: function(stat,type,msg) {
                            error_msg.push(msg.message);
                        }
                    });

                    $('#slctlocationmain').validator({
                        fieldLabel : '- Category',
                        selected: true,
                        error: function(stat,type,msg) {
                            error_msg.push(msg.message);
                        }
                    });

                    $('#slctstatus').validator({
                        fieldLabel : '- Status',
                        selected: true,
                        error: function(stat,type,msg) {
                            error_msg.push(msg.message);
                        }
                    });
                    $('#slctbilling').validator({
                        fieldLabel : '- Billing',
                        selected: true,
                        error: function(stat,type,msg) {
                            error_msg.push(msg.message);
                        }
                    });
                    $('#slctbooking').validator({
                        fieldLabel : '- Booking',
                        selected: true,
                        error: function(stat,type,msg) {
                            error_msg.push(msg.message);
                        }
                    });



                    $('#txtcode').validator('validate');
                    $('#txtname').validator('validate');
                    $('#txtdescription').validator('validate');
                    $('#txtcapacity').validator('validate');
                    $('#slctlocationmain').validator('validate');
                    $('#slctstatus').validator('validate');
                    $('#slctbilling').validator('validate');
                    $('#slctbooking').validator('validate');

                    var len = error_msg.length;
                    //error_msg.reverse();

                    if(error_msg.length != 0){
                        for(var i=0; i<len; i++){
                            //$('<li>'+error_msg[i]+'</li>').prependTo('#error');
                            error_msg[i];
                        }
                        alert(error_msg.join("\n"));
                        //alert(error_msg);
                        event.preventDefault();
                        return false;
                    }else{
                        //$('#n_error').hide();
                        $("#form1").attr('action','location_code_edit_save.php');
                        $("#form1").attr('method','post');
                        $("#form1").submit();

                        return true;
                    }
                });

                $("#btnclose").click( function(){
                    var mainP = parent.document.getElementById('ocewindow');
                    mainP.close();
                }
            );

            });
        </script>
    </head>
    <body>
        <form id="form1" action="">
            <ul class="form-style-1">
                <input type="hidden" id="txtseqno" name="seq_no" value="<?php echo encode($lmd_seq_no); ?>"/>
                <li>
                    <label for="name">Code<span class="required">*</span></label>
                    <input type="text" id="txtcode" name="code" maxlength="4" value="<?php echo $lmd_code; ?>" class="field-long"/>
                </li>
                <li>
                    <label for="name">Name<span class="required">*</span></label>
                    <input type="text" id="txtname" name="name" maxlength="50" value="<?php echo $lmd_name; ?>" class="field-long"/>
                </li>
                <li>
                    <label for="name">Description<span class="required">*</span></label>
                    <input type="text" id="txtdescription" name="description" value="<?php echo $lmd_desc; ?>" class="field-long"/>
                </li>
                <li>
                    <label for="name">Category<span class="required">*</span></label>
                    <select name="location_main" id="slctlocationmain">
                        <?
                        $stsystem  = "<option value=\"\">SELECT</option>\n";
                        for($i=0;$i<count($scode);$i++) {
                            $stsystem .= "<option value=\"".$scode[$i][0]."\" ".selected($scode[$i][0],$lmd_main_code)." >".$scode[$i][2]."</option>\n";
                        }
                        echo $stsystem;
                        ?>
                    </select>
                </li>
                <li>
                    <label for="name">Capacity<span class="required">*</span></label>
                    <input type="text" id="txtcapacity" name="capacity" value="<?php echo $lmd_capacity; ?>" class="field-devided"/>
                </li>
                <li>
                    <label for="name">Status<span class="required">*</span></label>
                    <select name="status" id="slctstatus">
                        <option value="" <?if($lmd_status == "")echo "selected";?>>SELECT</option>
                        <option value="Y" <?if($lmd_status == "Y")echo "selected";?>>YES</option>
                        <option value="N" <?if($lmd_status == "N")echo "selected";?>>NO</option>
                    </select>
                </li>
                <li>
                    <label for="name">Billing<span class="required">*</span></label>
                    <select name="billing" id="slctbilling">
                        <option value="" <?if($lmd_billing == "")echo "selected";?>>SELECT</option>
                        <option value="Y" <?if($lmd_billing == "Y")echo "selected";?>>YES</option>
                        <option value="N" <?if($lmd_billimg == "N")echo "selected";?>>NO</option>
                    </select>
                </li>
                <li>
                    <label for="name">Booking<span class="required">*</span></label>
                    <select name="booking" id="slctbooking">
                        <option value="" <?if($lmd_booking == "")echo "selected";?>>SELECT</option>
                        <option value="Y" <?if($lmd_booking == "Y")echo "selected";?>>YES</option>
                        <option value="N" <?if($lmd_booking == "N")echo "selected";?>>NO</option>
                    </select>
                </li>
                <li>
                    <button class="pure-button pure-button-primary" type="submit" id="btnsubmit">Submit</button>
                    <button  onclick="return close();" class="pure-button pure-button-primary_r" type="button" id="btnclose">Close</button>
                </li>
            </ul>
        </form>
    </body>
</html>