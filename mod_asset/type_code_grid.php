<script type="text/javascript">

    function type_code_edit(id){
        var tcewindow=dhtmlwindow.open('tcewindow', 'iframe', 'mod_asset/type_code_edit.php?id='+id, 'Edit Type Code',
        'width=600px,height=400px,center=1,resize=0,scrolling=1');

        tcewindow.onclose=function(){ //Define custom code to run when window is closed
            window.location.reload();
            return true;
        }
    } //End "opennewsletter" function
    function type_code_detail(id){
        var tcdwindow=dhtmlwindow.open('tcdwindow', 'iframe', 'mod_asset/type_code_detail.php?id='+id,
        'Type Code Info', 'width=600px,height=400px,center=1,resize=0,scrolling=1');

    }
    function type_code_add(){
        var tcawindow=dhtmlwindow.open('tcawindow', 'iframe', 'mod_asset/type_code_add.php',
        'Add Type Code', 'width=600px,height=400px,center=1,resize=0,scrolling=1');

        tcawindow.onclose=function(){ //Define custom code to run when window is closed
            window.location.reload();
            return true;
        }
    }
    function type_code_delete(id)
    {
        if (confirm("Are you sure you wish to delete this entry?"))
                 location.href='mod_asset/type_code_delete.php?id='+id;
    }
    function back(){
        location.href = "home.php?mod=s2&app=b4r5446426";
    }
</script>


<div class="table-container">
    <h2 id="p_title">Type Code</h2>
    <div align="right" style="padding-bottom: 10px; font-size:12px;">
        <button class="pure-button pure-button-primary" onclick="back(); return false" type="button" id="btnsubmit">Main Page</button>
        <button class="pure-button pure-button-primary_g" onclick="type_code_add(); return false" type="button" id="btnsubmit">Add New</button>
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
            $stmt = $db->prepare("SELECT `atc_seq_no`,`atc_type_code`,`atc_type_desc` FROM `asset_type_code` WHERE 1");
            $stmt->execute();
            $stmt-> bind_result($atc_seq_no,$atc_area_code,$atc_area_desc);
            while ($stmt->fetch()) {

                if ($y % 2 == 0) {
                    $odd = 'class = "pure-table-odd"';
                }else {
                    $odd = "";
                }
                ?>
            <tr <?php echo $odd;?>>
                <td><?php echo $y; ?></td>
                <td><?php echo output($atc_area_code);?></td>
                <td><?php echo output($atc_area_desc);?></td>
                <td>
                    <a href="#" onClick="type_code_detail('<?php echo encode($atc_seq_no);?>'); return false"><img src="include/img/detail3.png"></img></a>
                </td>
                <td>
                    <a href="#" onClick="type_code_edit('<?php echo encode($atc_seq_no);?>'); return false"><img src="include/img/edit2.png"></img></a>
                </td>
                <td>
                    <a href="#" onClick="type_code_delete('<?php echo encode($atc_seq_no);?>');return false"><img src="include/img/delete2.png"></img></a>
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
