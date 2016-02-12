<script type="text/javascript">

    function system_code_edit(id){
        var scewindow=dhtmlwindow.open('scewindow', 'iframe', 'mod_main/master/location_main_edit.php?id='+id, 'Edit Location Main Code',
        'width=600px,height=400px,center=1,resize=0,scrolling=1');

        scewindow.onclose=function(){ //Define custom code to run when window is closed
            window.location.reload();
            return true;
        }
    } //End "opennewsletter" function
    function system_code_detail(id){
        var scdwindow=dhtmlwindow.open('scdwindow', 'iframe', 'mod_main/master/location_main_detail.php?id='+id,
        'Location Main Code Info', 'width=600px,height=400px,center=1,resize=0,scrolling=1');

    }
    function system_code_add(){
        var scawindow=dhtmlwindow.open('scawindow', 'iframe', 'mod_main/master/location_main_add.php',
        'Add Location Main Code', 'width=600px,height=400px,center=1,resize=0,scrolling=1');

        scawindow.onclose=function(){ //Define custom code to run when window is closed
            window.location.reload();
            return true;
        }
    }
    function system_code_delete(id)
    {
        if (confirm("Are you sure you wish to delete this entry?"))
                 location.href='mod_main/master/location_main_delete.php?id='+id;
    }
    function back(){
        location.href = "home.php?mod=r2&app=b4r5446426";
    }
</script>


<div class="table-container">
    <h2 id="p_title">Location Main Code</h2>
    <div align="right" style="padding-bottom: 10px; font-size:12px;">
        <button class="pure-button pure-button-primary" onclick="back(); return false" type="button" id="btnsubmit">Main Page</button>
        <button class="pure-button pure-button-primary_g" onclick="system_code_add(); return false" type="button" id="btnsubmit">Add New</button>
    </div>
    <table id="tableid" class="pure-table" width="100%">
        <thead>
            <tr >
                <th width="5%">No</th>
                <th>Code</th>
                <th>Description</th>
                <th width="10%" colspan="4">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $y = 1;
            $db = MySQL::getInstance();
            $stmt = $db->prepare("SELECT `lm_seq_no`,`lm_code`,`lm_name` FROM `location_main` WHERE 1");
            $stmt->execute();
            $stmt-> bind_result($lm_seq_no,$lm_code,$lm_desc);
            while ($stmt->fetch()) {

                if ($y % 2 == 0) {
                    $odd = 'class = "pure-table-odd"';
                }else {
                    $odd = "";
                }
                ?>
            <tr <?php echo $odd;?>>
                <td><?php echo $y; ?></td>
                <td><?php echo output($lm_code);?></td>
                <td><?php echo output($lm_desc);?></td>
                <td>
                    <a href="#" onClick="system_code_detail('<?php echo encode($lm_seq_no);?>'); return false"><img src="include/img/detail3.png"></img></a>
                </td>
                <td>
                    <a href="#" onClick="system_code_edit('<?php echo encode($lm_seq_no);?>'); return false"><img src="include/img/edit2.png"></img></a>
                </td>
                <td>
                    <a href="#" onClick="system_code_delete('<?php echo encode($lm_seq_no);?>');return false"><img src="include/img/delete2.png"></img></a>
                </td>
            </tr>
                <?php $y++;
            }
            $stmt->close();
            $db->close();
            ?>
        </tbody>
    </table>
</div>
