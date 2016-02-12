<script type="text/javascript">

    function system_main_edit(id){
        var acewindow=dhtmlwindow.open('acewindow', 'iframe', 'mod_asset/system_main_edit.php?id='+id, 'Edit Area Code',
        'width=600px,height=400px,center=1,resize=0,scrolling=1');

        acewindow.onclose=function(){ //Define custom code to run when window is closed
            window.location.reload();
            return true;
        }
    } //End "opennewsletter" function
    function system_main_detail(id){
        var acdwindow=dhtmlwindow.open('acdwindow', 'iframe', 'mod_asset/system_main_detail.php?id='+id,
        'Area Code Info', 'width=600px,height=400px,center=1,resize=0,scrolling=1');

    }
    function system_main_add(){
        var acawindow=dhtmlwindow.open('acawindow', 'iframe', 'mod_asset/system_main_add.php',
        'Add Area Code', 'width=600px,height=400px,center=1,resize=0,scrolling=1');

        acawindow.onclose=function(){ //Define custom code to run when window is closed
            window.location.reload();
            return true;
        }
    }
    function system_main_delete(id)
    {
        if (confirm("Are you sure you wish to delete this entry?"))
                 location.href='mod_asset/system_main_delete.php?id='+id;
    }
    function back(){
        location.href = "home.php?mod=r2&app=b4r5446426";
    }
</script>


<div class="table-container">
    <h2 id="p_title">System Code</h2>
    <div align="right" style="padding-bottom: 10px; font-size:12px;">
        <button class="pure-button pure-button-primary" onclick="back(); return false" type="button" id="btnsubmit">Main Page</button>
        <button class="pure-button pure-button-primary_g" onclick="system_main_add(); return false" type="button" id="btnsubmit">Add New</button>
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
            $stmt = $db->prepare("SELECT `asm_seq_no`,`asm_system_code`,`asm_system_desc` FROM `apps_system_main` WHERE 1");
            $stmt->execute();
            $stmt-> bind_result($asm_seq_no,$asm_system_code,$asm_system_desc);
            while ($stmt->fetch()) {
                if ($y % 2 == 0) {
                    $odd = 'class = "pure-table-odd"';
                }else {
                    $odd = "";
                }
                ?>
            <tr <?php echo $odd;?>>
                <td><?php echo $y; ?></td>
                <td><?php echo output($asm_system_code);?></td>
                <td><?php echo output($asm_system_desc);?></td>
                <td>
                    <a href="#" onClick="system_main_detail('<?php echo encode($aac_seq_no);?>'); return false"><img src="include/img/detail3.png"/></a>
                </td>
                <td>
                    <a href="#" onClick="system_main_edit('<?php echo encode($aac_seq_no);?>'); return false"><img src="include/img/edit2.png"/></a>
                </td>
                <td>
                    <a href="#" onClick="system_main_delete('<?php echo encode($aac_seq_no);?>');return false"><img src="include/img/delete2.png"/></a>
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
