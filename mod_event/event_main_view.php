<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
<link href="../include/css/form.css" rel='stylesheet' type='text/css' />
<link href="../include/css/buttons.css" rel='stylesheet' type='text/css' />
<link  href="../include/css/tabs.css" rel="stylesheet" type='text/css'/>
<script type="text/javascript" src="../include/js/jquery.min.js"></script>
<script type="text/javascript" src="../include/js/validation.js"></script>
<script type="text/javascript" language="javascript">
    $(document).ready(function(){
        
        $('#btnsubmit').click(function(event) {

            var error_msg  = [];
            $('#txtcode').validator({
                fieldLabel : '- Area Code',
                invalidEmpty: true,
                noSpaceFirstLast: true,
                format: 'numeric',
                error: function(stat,type,msg) {
                    error_msg.push(msg.message);
              }
            });


            $('#txtdescription').validator({
                fieldLabel : '- Area Code Description',
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
                $("#form1").attr('action','area_code_add_save.php');
                $("#form1").attr('method','post');
                $("#form1").submit();
                return true;
            }
        });

        $("#btnclose").click( function(){
             var mainP = parent.document.getElementById('googlebox');
             mainP.close();
           }
        );
});
</script>
</head>
<body>
<?php
function taburl(){return $taburl ="?mod=f4e594f4&app=m4e524k4&tabIndex=";}
require_once '../include/tabs.php';
tabs_header(); ?>
<div style="width:100%;">
<?php tabs_start(); ?>
<?php tab( "Location" ); ?>
<?php echo "hi"; ?>
<?php tab( "Position" ); ?>
<?php tab( "Item Type" ); ?>
<?php tabs_end(); ?>
    </div>
</body>
</html>