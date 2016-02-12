<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<link href="../include/css/form.css" rel='stylesheet' type='text/css' />
<link href="../include/css/buttons.css" rel='stylesheet' type='text/css' />
<script type="text/javascript" src="../include/js/jquery.min.js"></script>
<script type="text/javascript" src="../include/js/validation.js"></script>
<script type="text/javascript" language="javascript">
    $(document).ready(function(){
	$('#n_error').hide();
        $('#btnsubmit').click(function(event) {
            
            var error_msg  = [];
            $('#txtname').validator({
                fieldLabel : '- Title',
                invalidEmpty: true,
                noSpaceFirstLast: true,
                error: function(stat,type,msg) {
                    error_msg.push(msg.message);
              }
            });

            $('#slctcategory').validator({
                fieldLabel : '- Category',
                selected: true,
                error: function(stat,type,msg) {
                    error_msg.push(msg.message);
                }
            });

            $('#content').validator({
                fieldLabel : '- Page',
                invalidEmpty: true,
                noSpaceFirstLast: true,
                error: function(stat,type,msg) {
                    error_msg.push(msg.message);
              }
            });


            $('#txtname').validator('validate');
            $('#slctcategory').validator('validate');
            $('#content').validator('validate');

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
                return true;
            }
        });
    });
</script>
</head>
<body>
<form action="" method="post">
<ul class="form-style-1">
    <li>
   <label for="name">Page title <span class="required">*</span></label>
    <input type="text" id="txtname" name="name" class="field-long"/>
    </li>
 <li>
    <label for="category">Category <span class="required">*</span></label>
    <select name="category" id="slctcategory" class="field-select">
        <option value="">-- select category</option>
        <option value="1">Category 1</option>
        <option value="2">Category 4</option>
        <option value="3">Category 3</option>
    </select>
    </li>
 <li>
    <label for="comments">Comments</label>
    <input type="radio" name="comments" value="on" checked="checked" /> Enabled <input type="radio" name="comments" value="off" /> Disabled
    </li>
 <li>
    <label for="attach">Attachments</label>
    <input type="file" name="attach" />
    </li>
    
 <li>
    <label for="content">Page content <span class="required">*</span></label>
    <textarea name="content" id="content" class="textarea" rows="10" class="field-long field-textarea"></textarea>
    </li>

    <li>
     <button class="pure-button pure-button-primary" type="submit" id="btnsubmit">Submit</button>
</li>
    </ul>
    </form>
</body>
</html>