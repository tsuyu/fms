<div class="table-container">
    <input type="hidden" id="ipp" name="ipp" value="<?php echo $_GET['ipp'];?>" />
    <input type="hidden" id="page" name="page" value="<?php echo $_GET['page'];?>" />
    <h2 id="p_title">Resource Booking Location</h2>
    <div align="right" style="padding-bottom: 10px; font-size:12px;">
         <button class="pure-button pure-button-primary_g" onclick="ns.book(<?php echo $lmd_seq_no;?>); return false" type="button" id="btnsubmit">Add New</button>
        <button class="pure-button pure-button-primary" onclick="ns.back(); return false" type="button" id="btnsubmit">Main Page</button>
    </div>
    <table class="pure-table" width="100%">
        <thead>
            <tr >
                <th width="5%">No</th>
                <th>Name</th>
                <th>Desc</th>
                <th>Capacity</th>
                <th width="5%" colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $y = 1;
            $db = MySQL::getInstance();
            $stmt = $db->prepare("SELECT `lmd_seq_no`,`lmd_name`,`lmd_desc`,`lmd_capacity` FROM `location_main_detail` WHERE 1");
            $stmt->execute();
            $stmt-> bind_result($lmd_seq_no,$lmd_name,$lmd_desc,$lmd_capacity);
            while ($stmt->fetch()) {
                if ($y % 2 == 0) {
                    $odd = 'class = "pure-table-odd"';
                }else {
                    $odd = "";
                }
                ?>
            <tr <?php echo $odd;?>>
                <td><?php echo $y; ?></td>
                <td><?php echo output($lmd_name);?></td>
                <td><?php echo output($lmd_desc);?></td>
                <td><?php echo output($lmd_capacity);?></td>
                 <td>
                    <a href="#" onClick="user_main_edit('<?php echo encode($lmd_seq_no);?>','<?php echo $_GET['ipp'];?>','<?php echo $_GET['page'];?>'); return false"><img src="include/img/edit2.png"/></a>
                </td>
                <td>
                    <a href="#" onClick="user_main_delete('<?php echo encode($lmd_seq_no);?>','<?php echo $_GET['ipp'];?>','<?php echo $_GET['page'];?>');return false"><img src="include/img/delete2.png"/></a>
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
<script type="text/javascript">

    var namespace;
    namespace = {
        book : function(id){
            location.href = "home.php?mod=u2&app=k4i5j4g4z5p464e454k5k4o4f4c4e4l54464c4k4i5m5u5&id="+id;
        },
        back : function(){
            location.href = "home.php?mod=u2&app=b4r5446426";
        }
    };
    window.ns = namespace;

</script>
