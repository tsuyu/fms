<script type="text/javascript" language="javascript">
    $(document).ready(function(){
	$('#n_error').hide();
        $('#btnsubmit').click(function(event) {
           
            var error_msg  = [];
                      
            $('#txtname').validator({
                fieldLabel : 'Page',
                invalidEmpty: true,
                noSpaceFirstLast: true,
                error: function(stat,type,msg) {
                    error_msg.push(msg.message);
              }
           });
		
            $('#slctcategory').validator({
                fieldLabel : 'Category',
                selected: true,
                error: function(stat,type,msg) {
                    error_msg.push(msg.message);
                }
            });
                      
            $('#txtname').validator('validate');
            $('#slctcategory').validator('validate');
		  
            var len = error_msg.length;
			
	        error_msg.reverse();
			
            if(error_msg.length != 0){
                $('#error').empty();
                $('#n_error').show();
				for(var i=0; i<len; i++){
                    $('<li>'+error_msg[i]+'</li>').prependTo('#error');
                }
                event.preventDefault();
                return false;
            }else{
                $('#n_error').hide();
                return true;
            }
        });
    });
</script>
<div class="full_w">
    <div class="h_title">Add new page - form elements</div>
    <div class="n_error" id="n_error"><br/><ul id="error"></ul><br/></div>
    <form action="" method="post">
        <div class="element">
            <label for="name">Page title <span class="red">(required)</span></label>
            <input type="text" id="txtname" name="name" />
        </div>
        <div class="element">
            <label for="category">Category <span>(required)</span></label>
            <select name="category" id="slctcategory">
                <option value="">-- select category</option>
                <option value="1">Category 1</option>
                <option value="2">Category 4</option>
                <option value="3">Category 3</option>
            </select>
        </div>
        <div class="element">
            <label for="comments">Comments</label>
            <input type="radio" name="comments" value="on" checked="checked" /> Enabled <input type="radio" name="comments" value="off" /> Disabled
        </div>
        <div class="element">
            <label for="attach">Attachments</label>
            <input type="file" name="attach" />
        </div>
        <div class="element">
            <label for="content">Page content <span>(required)</span></label>
            <textarea name="content" class="textarea" rows="10"></textarea>
        </div>
        <div class="entry">
            <button type="submit">Preview</button><button type="submit" id="btnsubmit" class="add">Save page</button> <button class="cancel">Cancel</button>
        </div>
    </form>
</div>