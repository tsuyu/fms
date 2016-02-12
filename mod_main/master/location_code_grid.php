<script type="text/javascript">

    function location_code_edit(id){
        var ocewindow=dhtmlwindow.open('ocewindow', 'iframe', 'mod_main/master/location_code_edit.php?id='+id, 'Edit Other Code',
        'width=600px,height=400px,center=1,resize=0,scrolling=1');

        ocewindow.onclose=function(){ //Define custom code to run when window is closed
            window.location.reload();
            return true;
        }
    } //End "opennewsletter" function
    function location_code_detail(id){
        var ocdwindow=dhtmlwindow.open('ocdwindow', 'iframe', 'mod_main/master/location_code_detail.php?id='+id,
        'Location Code Info', 'width=600px,height=400px,center=1,resize=0,scrolling=1');

    }
    function location_code_add(){
        var ocawindow=dhtmlwindow.open('ocawindow', 'iframe', 'mod_main/master/location_code_add.php',
        'Add Location Code', 'width=600px,height=400px,center=1,resize=0,scrolling=1');

        ocawindow.onclose=function(){ //Define custom code to run when window is closed
            window.location.reload();
            return true;
        }
    }
    function location_code_delete(id)
    {
        if (confirm("Are you sure you wish to delete this entry?"))
            location.href='mod_main/master/location_code_delete.php?id='+id;
    }
    function back(){
        location.href = "home.php?mod=r2&app=b4r5446426";
    }
</script>


<div class="table-container">
    <h2 id="p_title">Location Detail</h2>
    <div align="right" style="padding-bottom: 10px; font-size:12px;">
        <button class="pure-button pure-button-primary" onclick="back(); return false" type="button" id="btnsubmit">Main Page</button>
        <button class="pure-button pure-button-primary_g" onclick="location_code_add(); return false" type="button" id="btnsubmit">Add New</button>
    </div>
    <table class="pure-table" width="100%">
        <thead>
            <tr >
                <th width="5%">No</th>
                <th>Code</th>
                <th>Name</th>
                <th>Category</th>
                <th>Description</th>
                <th>Capacity</th>
                <th>Billing</th>
                <th>Booking</th>
                <th width="10%" colspan="4">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $y = 1;
            $db = MySQL::getInstance();
            $stmt = $db->prepare("SELECT `lmd_seq_no`,`lm_name`,`lmd_code`,`lmd_name`,`lmd_desc`,`lmd_capacity`,
                    `lmd_booking`,`lmd_billing`
                    FROM `location_main_detail`
                    JOIN `location_main` WHERE 1 AND `lmd_main_code` = `lm_code`
                    ORDER BY `lmd_code` ");
            $stmt->execute();
            $stmt-> bind_result($lmd_seq_no,$lm_name,$lmd_code,$lmd_name,$lmd_desc,$lmd_capacity,$lmd_booking,$lmd_billing);
            while ($stmt->fetch()) {
                if ($y % 2 == 0) {
                    $odd = 'class = "pure-table-odd"';
                }else {
                    $odd = "";
                }
                ?>
            <tr <?php echo $odd;?>>
                <td><?php echo $y; ?></td>
                <td><?php echo output($lmd_code);?></td>
                <td><?php echo output($lmd_name);?></td>
                <td><?php echo output($lm_name);?></td>
                <td><?php echo output($lmd_desc);?></td>
                <td><?php echo output($lmd_capacity);?></td>
                <td><?php echo output($lmd_billing);?></td>
                <td><?php echo output($lmd_booking);?></td>
                <td>
                    <a href="#" onClick="location_code_detail('<?php echo encode($lmd_seq_no);?>'); return false"><img src="include/img/detail3.png"></img></a>
                </td>
                <td>
                    <a href="#" onClick="location_code_edit('<?php echo encode($lmd_seq_no);?>'); return false"><img src="include/img/edit2.png"></img></a>
                </td>
                <td>
                    <a href="#" onClick="location_code_delete('<?php echo encode($lmd_seq_no);?>');return false"><img src="include/img/delete2.png"></img></a>
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
