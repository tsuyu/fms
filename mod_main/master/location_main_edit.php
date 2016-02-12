<?php
header('P3P: CP="CAO PSA OUR"');
require_once '../../include/util/class.util.php';
require_once '../../include/helper.php';
require_once '../../class.adapter.php';
//require_once '../session.php';
//$session = new session();
// Set to true if using https
//$session->start_session('_s', false);

$db = MySQL::getInstance();
$stmt = $db->prepare("SELECT `lm_seq_no`,`lm_name`
    FROM `location_main` WHERE `lm_seq_no` = ? LIMIT 1");
$stmt->bind_param("s", decode($_GET['id']));
$stmt->execute();
$stmt->bind_result($lm_seq_no,$lm_name);
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
            
            $('#txtdescription').validator({
                fieldLabel : '- Location Main Description',
                invalidEmpty: true,
                noSpaceFirstLast: true,
                error: function(stat,type,msg) {
                    error_msg.push(msg.message);
              }
            });


            $('#txtdescription').validator('validate');

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
                $("#form1").attr('action','location_main_edit_save.php');
                $("#form1").attr('method','post');
                $("#form1").submit();

                return true;
            }
        });

        $("#btnclose").click( function(){
             var mainP = parent.document.getElementById('scewindow');
             mainP.close();
           }
        );
            
    });
</script>
</head>
<body>
    <form id="form1" action="">
<ul class="form-style-1">
     <input type="hidden" id="txtseqno" name="seq_no" value="<?php echo encode($lm_seq_no); ?>"/>
    <li>
   <label for="name">Description<span class="required">*</span></label>
    <input type="text" id="txtdescription" name="description" value="<?php echo $lm_name; ?>" class="field-long"/>
    </li>
    <li>
     <button class="pure-button pure-button-primary" type="submit" id="btnsubmit">Submit</button>
     <button  onclick="return close();" class="pure-button pure-button-primary_r" type="button" id="btnclose">Close</button>
</li>
    </ul>
    </form>
</body>
</html>