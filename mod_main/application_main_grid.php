<script type="text/javascript">

    function application_main_edit(id){
        var acewindow=dhtmlwindow.open('acewindow', 'iframe', 'mod_asset/application_main_edit.php?id='+id, 'Edit Area Code',
        'width=600px,height=400px,center=1,resize=0,scrolling=1');

        acewindow.onclose=function(){ //Define custom code to run when window is closed
            window.location.reload();
            return true;
        }
    } //End "opennewsletter" function
    function application_main_detail(id){
        var acdwindow=dhtmlwindow.open('acdwindow', 'iframe', 'mod_asset/application_main_detail.php?id='+id,
        'Area Code Info', 'width=600px,height=400px,center=1,resize=0,scrolling=1');

    }
    function application_main_add(){
        var acawindow=dhtmlwindow.open('acawindow', 'iframe', 'mod_asset/application_main_add.php',
        'Add Area Code', 'width=600px,height=400px,center=1,resize=0,scrolling=1');

        acawindow.onclose=function(){ //Define custom code to run when window is closed
            window.location.reload();
            return true;
        }
    }
    function application_main_delete(id)
    {
        if (confirm("Are you sure you wish to delete this entry?"))
            location.href='mod_asset/application_main_delete.php?id='+id;
    }
    function back(){
        location.href = "home.php?mod=r2&app=b4r5446426";
    }
</script>


<div class="table-container">
    <h2 id="p_title">Page Code</h2>
    <div align="right" style="padding-bottom: 10px; font-size:12px;">
        <button class="pure-button pure-button-primary" onclick="back(); return false" type="button" id="btnsubmit">Main Page</button>
        <button class="pure-button pure-button-primary_g" onclick="application_main_add(); return false" type="button" id="btnsubmit">Add New</button>
    </div>
    <table class="pure-table" width="100%">
        <thead>
            <tr >
                <th width="5%">No</th>
                <th>Page Code</th>
                <th>Module</th>
                <th>Page Description</th>
                <th>Status</th>
                <th width="10%" colspan="4">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $y = 1;
            $db = MySQL::getInstance();
            $stmt = $db->prepare("SELECT `aam_seq_no`,`aam_application_code`,`amm_module_desc`,`aam_application_desc`,`aam_application_status`
                FROM `apps_application_main` JOIN `apps_module_main` ON  `aam_module_code` =  `amm_module_code` WHERE 1
                ORDER BY `aam_application_code`");
            $stmt->execute();
            $stmt-> bind_result($aam_seq_no,$aam_application_code,$aam_module_code,$aam_application_desc,$aam_application_status);
            while ($stmt->fetch()) {

                if ($y % 2 == 0) {
                    $odd = 'class = "pure-table-odd"';
                }else {
                    $odd = "";
                }
                ?>
            <tr <?php echo $odd;?>>
                <td><?php echo $y; ?></td>
                <td><?php echo output($aam_application_code);?></td>
                <td><?php echo output($aam_module_code);?></td>
                <td><?php echo output($aam_application_desc);?></td>
                <td><?php echo output($aam_application_status);?></td>
                <td><a href="#" onClick="application_main_detail('<?php echo encode($aac_seq_no);?>'); return false"><img src="include/img/detail3.png"/></a>
                </td>
                <td><a href="#" onClick="application_main_edit('<?php echo encode($aac_seq_no);?>'); return false"><img src="include/img/edit2.png"/></a>
                </td>
                <td><a href="#" onClick="application_main_delete('<?php echo encode($aac_seq_no);?>');return false"><img src="include/img/delete2.png"/></a>
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