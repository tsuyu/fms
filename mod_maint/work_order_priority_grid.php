<script type="text/javascript">

    function work_order_priority_edit(id,ipp,page){
        location.href='home.php?mod=r2&app=n4w554j4d5k444i4k4h5c4r4d474z3j594b4r4&id='+id+"&page="+page+"&ipp="+ipp;
    }

    function work_order_priority_detail(id){
        var acdwindow=dhtmlwindow.open('acdwindow', 'iframe', 'mod_asset/work_order_priority_detail.php?id='+id,
        'Area Code Info', 'width=600px,height=400px,center=1,resize=0,scrolling=1');

    }
    function work_order_priority_add(){
        location.href="home.php?mod=r2&app=n4w554j4d5k444i4k4h5c4r4d474z3f59464&page="+page+"&ipp="+ipp;
    }
    function work_order_priority_delete(id)
    {
        if (confirm("Are you sure you wish to delete this entry?"))
            location.href='home.php?mod=r2&app=n4w554j4d5k444i4k4h5c4r4d474z3i5a4e4c4k4m5&id='+id+"&page="+page+"&ipp="+ipp;
    }
    function back(){
        location.href = "home.php?mod=t2&app=b4r5446426";
    }
</script>
<div class="table-container">
    <input type="hidden" id="ipp" name="ipp" value="<?php echo $_GET['ipp'];?>" />
    <input type="hidden" id="page" name="page" value="<?php echo $_GET['page'];?>" />
    <h2 id="p_title">Work Order Priority</h2>
    <div align="right" style="padding-bottom: 10px; font-size:12px;">
        <button class="pure-button pure-button-primary" onclick="back(); return false" type="button" id="btnsubmit">Main Page</button>
        <button class="pure-button pure-button-primary_g" onclick="work_order_priority_add(); return false" type="button" id="btnsubmit">Add New</button>
    </div>
    <table class="pure-table" width="100%">
        <thead>
            <tr >
                <th width="5%">No</th>
                <th>Code</th>
                <th>Description</th>
                <th width="5%" colspan="4">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $y = 1;
            $db = MySQL::getInstance();
            $stmt = $db->prepare("SELECT `wop_seq_no`,`wop_priority_desc` FROM `work_order_priority` WHERE 1");
            $stmt->execute();
            $stmt-> bind_result($wop_seq_no,$wop_priority_desc);
            while ($stmt->fetch()) {
                if ($y % 2 == 0) {
                    $odd = 'class = "pure-table-odd"';
                }else {
                    $odd = "";
                }
                ?>
            <tr <?php echo $odd;?>>
                <td><?php echo $y; ?></td>
                <td><?php echo output($wop_seq_no);?></td>
                <td><?php echo output($wop_priority_desc);?></td>
                <td>
                    <a href="#" onClick="work_order_priority_edit('<?php echo encode($wop_seq_no);?>','<?php echo $_GET['ipp'];?>','<?php echo $_GET['page'];?>'); return false"><img src="include/img/edit2.png"/></a>
                </td>
                <td>
                    <a href="#" onClick="work_order_priority_delete('<?php echo encode($wop_seq_no);?>','<?php echo $_GET['ipp'];?>','<?php echo $_GET['page'];?>');return false"><img src="include/img/delete2.png"/></a>
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