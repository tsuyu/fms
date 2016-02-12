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
                fieldLabel : '- Campus Code',
                invalidEmpty: true,
                noSpaceFirstLast: true,
                format: 'numeric',
                error: function(stat,type,msg) {
                    error_msg.push(msg.message);
              }
            });

             var error_msg  = [];
            $('#txtdescription').validator({
                fieldLabel : '- Campus Code Description',
                invalidEmpty: true,
                noSpaceFirstLast: true,
                error: function(stat,type,msg) {
                    error_msg.push(msg.message);
              }
            });


            $('#txtcode').validator('validate');
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
                $("#form1").attr('action','campus_code_add_save.php');
                $("#form1").attr('method','post');
                $("#form1").submit();
                return true;
            }
        });

        $("#btnclose").click( function(){
             var mainP = parent.document.getElementById('ccawindow');
             mainP.close();
           }
        );
});  
</script>
</head>
<body>

    <form  id="form1" action="" method="post">
<ul class="form-style-1">
    <li>
   <label for="name">Campus Code<span class="required">*</span></label>
   <input type="text" id="txtcode" name="code"  maxlength="1" value="" class="field-long"/>
    </li>
    <li>
   <label for="name">Campus Code Description<span class="required">*</span></label>
    <input type="text" id="txtdescription" name="description" value="" class="field-long"/>
    </li>
    <li>
      <?php
        $new = "Add";
        if($_GET['new'] == 1){
            $new = "Add Another Record";
        }
      ?>
     <button class="pure-button pure-button-primary" type="submit" id="btnsubmit"><?php echo $new; ?></button>&nbsp;
     <button  onclick="return close();" class="pure-button pure-button-primary_r" type="button" id="btnclose">Close</button>
    </li>
    </ul>
    </form>
</body>
</html>