<script type="text/javascript">

    function utility_rate_edit(id){
        var acewindow=dhtmlwindow.open('acewindow', 'iframe', 'mod_tenant/bill_grid_rate_edit.php?id='+id, 'Edit Utility Bill Rates',
        'width=600px,height=400px,center=1,resize=0,scrolling=1');

        acewindow.onclose=function(){ //Define custom code to run when window is closed
            window.location.reload();
            return true;
        }
    }
    function back(){
        location.href = "home.php?mod=v2&app=b4r5446426";
    }
</script>

<div class="table-container">
    <h2 id="p_title">Utility Bill Unit Rates</h2>
    <div align="right" style="padding-bottom: 10px; font-size:12px;">
        <button class="pure-button pure-button-primary" onclick="back(); return false" type="button" id="btnsubmit">Main Page</button>
     </div>
    <table class="pure-table" width="100%">
        <thead>
            <tr >
                <th width="5%">No</th>
                <th>Electrical (per/Unit)</th>
                <th>Water (per/Unit)</th>
                <th width="1%">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $y = 1;
            $db = MySQL::getInstance();
            $stmt = $db->prepare("SELECT `ubr_seq_no`,`ubr_electric_rate`,`ubr_water_rate` FROM `utility_bill_rates` WHERE 1");
            $stmt->execute();
            $stmt-> bind_result($ubr_seq_no,$ubr_electric_rate,$ubr_water_rate);
            while ($stmt->fetch()) {

                if ($y % 2 == 0) {
                    $odd = 'class = "pure-table-odd"';
                }else {
                    $odd = "";
                }
                ?>
            <tr <?php echo $odd;?>>
                <td><?php echo $y; ?></td>
                <td><?php echo output($ubr_electric_rate);?></td>
                <td><?php echo output($ubr_water_rate);?></td>
                <td>
                    <a href="#" onClick="utility_rate_edit('<?php echo encode($ubr_seq_no);?>'); return false"><img src="include/img/edit2.png"></img></a>
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
