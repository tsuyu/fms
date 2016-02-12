<script type="text/javascript">

    function level_code_edit(id){
        var lcewindow=dhtmlwindow.open('lcewindow', 'iframe', 'mod_main/master/level_code_edit.php?id='+id, 'Edit Level Code',
        'width=600px,height=400px,center=1,resize=0,scrolling=1');

        lcewindow.onclose=function(){ //Define custom code to run when window is closed
            window.location.reload();
            return true;
        }
    } //End "opennewsletter" function
    function level_code_detail(id){
        var acdwindow=dhtmlwindow.open('lcdwindow', 'iframe', 'mod_main/master/level_code_detail.php?id='+id,
        'Level Code Info', 'width=600px,height=400px,center=1,resize=0,scrolling=1');

    }
    function level_code_add(){
        var lcawindow=dhtmlwindow.open('lcawindow', 'iframe', 'mod_main/master/level_code_add.php',
        'Add Level Code', 'width=600px,height=400px,center=1,resize=0,scrolling=1');

        lcawindow.onclose=function(){ //Define custom code to run when window is closed
            window.location.reload();
            return true;
        }
    }
    function level_code_delete(id)
    {
        if (confirm("Are you sure you wish to delete this entry?"))
                 location.href='mod_main/master/level_code_delete.php?id='+id;
    }
    function back(){
        location.href = "home.php?mod=r2&app=b4r5446426";
    }
</script>


<div class="table-container">
    <h2 id="p_title">Level Code</h2>
    <div align="right" style="padding-bottom: 10px; font-size:12px;">
        <button class="pure-button pure-button-primary" onclick="back(); return false" type="button" id="btnsubmit">Main Page</button>
        <button class="pure-button pure-button-primary_g" onclick="level_code_add(); return false" type="button" id="btnsubmit">Add New</button>
    </div>
    <table class="pure-table" width="100%">
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
            $stmt = $db->prepare("SELECT `blm_seq_no`,`blm_level_code`,`blm_level_desc` FROM `building_level_main` WHERE 1");
            $stmt->execute();
            $stmt-> bind_result($blm_seq_no,$blm_area_code,$blm_area_desc);
            while ($stmt->fetch()) {

                if ($y % 2 == 0) {
                    $odd = 'class = "pure-table-odd"';
                }else {
                    $odd = "";
                }
                ?>
            <tr <?php echo $odd;?>>
                <td><?php echo $y; ?></td>
                <td><?php echo output($blm_area_code);?></td>
                <td><?php echo output($blm_area_desc);?></td>
                <td>
                    <a href="#" onClick="level_code_detail('<?php echo encode($blm_seq_no);?>'); return false"><img src="include/img/detail3.png"></img></a>
                </td>
                <td>
                    <a href="#" onClick="level_code_edit('<?php echo encode($blm_seq_no);?>'); return false"><img src="include/img/edit2.png"></img></a>
                </td>
                <td>
                    <a href="#" onClick="level_code_delete('<?php echo encode($blm_seq_no);?>');return false"><img src="include/img/delete2.png"></img></a>
                </td>
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
