<?php
if(isset($_POST['day_from']) && !empty ($_POST['day_from'])) {
    $day_from = sanitize($_POST['day_from']);
}
if(isset($_POST['month_from']) && !empty ($_POST['month_from'])) {
    $month_from = sanitize($_POST['month_from']);
}
if(isset($_POST['year_from']) && !empty ($_POST['year_from'])) {
    $year_from = sanitize($_POST['year_from']);
}
if(isset($_POST['day_to']) && !empty ($_POST['day_to'])) {
    $day_to = sanitize($_POST['day_to']);
}
if(isset($_POST['month_to']) && !empty ($_POST['month_to'])) {
    $month_to = sanitize($_POST['month_to']);
}
if(isset($_POST['year_to']) && !empty ($_POST['year_to'])) {
    $year_to = sanitize($_POST['year_to']);
}
if(isset($_POST['year_to']) && !empty ($_POST['year_to'])) {
    $year_to = sanitize($_POST['year_to']);
}
if(isset($_POST['year_to'])) {
    $from = strtotime($year_from."-".$month_from."-".$day_from." 00:00:00");
    $to = strtotime($year_to."-".$month_to."-".$day_to." 23:59:59");
}
//dumper($_POST)
//echo encode('bill_grid_delete');
?>
<form id="form2" action="">
    <?php
    $earliest_year = 2014;
    ?>
    <table class="pure-table2" width="100%">
        <thead>
        </thead>
        <tbody>
            <tr class = "pure-table2-odd">
                <td colspan="4"><b>Search for particular period</b><input type="hidden" name="mode"  id="mode" value=""/></td>
            </tr>
            <tr>
                <td width="30%"></td>
                <td>Date From</td><td><select name="day_from">
                        <?php
                        for($x = 1; $x <= 31; $x++) {
                            echo "<option value=\"".zero_pad($x, 2)."\" ".selected(zero_pad($x, 2),$day_from)." >".zero_pad($x, 2)."</option>";
                        }
                        ?>
                    </select>
                    <select name="month_from">
                        <?php
                        for($y = 1; $y <= 12; $y++) {
                            echo "<option value=\"".zero_pad($y, 2)."\" ".selected(zero_pad($y, 2),$month_from)." >".zero_pad($y, 2)."</option>";
                        }
                        ?>
                    </select>
                    <select name="year_from">
                        <?php
                        if(!isset($_POST['mode']) && empty ($_POST['mode'])) {
                            $currently_selected = date('Y');
                        }else {
                            $currently_selected = $year_from;
                        }
                        $latest_year = date('Y', strtotime('+1 years'));
                        foreach ( range( $latest_year, $earliest_year ) as $i ) {
                            echo $i;
                            echo '<option value="'.$i.'"'.($i == $currently_selected ? ' selected="selected"' : '').'>'.$i.'</option>';
                        }
                        ?>
                    </select>
                </td>
                <td width="30%"></td>
            </tr>
            <tr>
                <td width="30%"></td>
                <td>Date To</td><td><select name="day_to">
                        <?php
                        for($x = 1; $x <= 31; $x++) {
                            echo "<option value=\"".zero_pad($x, 2)."\" ".selected(zero_pad($x, 2),$day_to)." >".zero_pad($x, 2)."</option>";
                        }
                        ?>
                    </select>
                    <select name="month_to">
                        <?php
                        for($y = 1; $y <= 12; $y++) {
                            echo "<option value=\"".zero_pad($y, 2)."\" ".selected(zero_pad($y, 2),$month_to)." >".zero_pad($y, 2)."</option>";
                        }
                        ?>
                    </select>
                    <select name="year_to">
                        <?php
                        if(!isset($_POST['mode']) && empty ($_POST['mode'])) {
                            $currently_selected = date('Y');
                        }else {
                            $currently_selected = $year_to;
                        }
                        $latest_year = date('Y', strtotime('+1 years'));
                        foreach ( range( $latest_year, $earliest_year ) as $i ) {
                            echo $i;
                            echo '<option value="'.$i.'"'.($i == $currently_selected ? ' selected="selected"' : '').'>'.$i.'</option>';
                        }
                        ?>
                    </select></td>
                <td width="30%"></td>
            </tr>
            <tr>
                <td width="60%" colspan="3" align="right">
                    <button class="pure-button pure-button-primary_r" onclick="ns.reset(<?php echo $_GET['id']; ?>); return false" type="button" id="btnsubmit">Reset</button>
                    <button name="search" class="pure-button pure-button-primary_g" onclick="ns.search(); return false" type="button" id="search">Search</button></td>
                <td width="30%"></td>
            </tr>
        </tbody>
    </table>
</form>
<br/>
<div align="right">
    <button class="pure-button pure-button-primary_r" onclick="ns.batch(); return false" type="button" id="btnsubmit">New Batch</button>
    <button class="pure-button pure-button-primary" onclick="ns.back(); return false" type="button" id="btnsubmit">Back</button>
</div>
<br/>
<table class="pure-table" width="100%">
    <thead>
        <tr >
            <th></th>
            <th width="8%">Batch No</th>
            <th width="8%">Compare Batch No</th>
            <th>Date From</th>
            <th>Date To</th>
            <th>Post Date</th>
            <th>Electric Bill (RM)</th>
            <th>Water Bill (RM)</th>
            <th>Grand Total (RM)</th>
            <th>Post Status</th>
            <th width="15%">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $y = 1;
        $db = MySQL::getInstance();
        $sql = "SELECT `ubm_seq_no`,`ubm_batch_no`,`ubm_obatch_no`, DATE_FORMAT(`ubm_from_date`,'%d-%m-%Y'),DATE_FORMAT(`ubm_to_date`,'%d-%m-%Y'),DATE_FORMAT(`ubm_process_date`,'%d-%m-%Y'),
                `ubm_process_status`, `ubm_grand_total`, `ubm_electric_total`,`ubm_water_total`
                FROM `utility_bill_main` WHERE 1";
        if(isset($from) && isset ($to)) {
            $sql .=" AND UNIX_TIMESTAMP(`ubm_from_date`) >= '".$from."'
                     AND UNIX_TIMESTAMP(`ubm_to_date`) <= '".$to."' ";
        }
        $sql .=" ORDER BY `ubm_from_date` DESC ";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $stmt-> bind_result($ubm_seq_no,$ubm_batch_no,$ubm_obatch_no,$ubm_from_date,$ubm_to_date,$ubm_process_date,$ubm_process_status,$ubm_grand_total,$ubm_electric_total,$ubm_water_total);
        while ($stmt->fetch()) {
            if ($y % 2 == 0) {
                $odd = 'class = "pure-table-odd"';
            }else {
                $odd = "";
            }
            ?>
        <tr <?php echo $odd;?>>
            <td><?php echo $y; ?></td>
            <td><b><?php echo output($ubm_batch_no);?></b></td>
            <td><?php echo output($ubm_obatch_no);?></td>
            <td><?php echo output($ubm_from_date);?></td>
            <td><?php echo output($ubm_to_date);?></td>
            <td><?php echo output($ubm_process_date);?></td>
            <td><?php echo output(number_format($ubm_electric_total,2));?></td>
            <td><?php echo output(number_format($ubm_water_total,2));?></td>
            <td><b><?php echo output(number_format($ubm_grand_total,2));?></b></td>
            <td><b><?php echo output($ubm_process_status);?></b></td>
            <td>
                <button class="pure-button pure-button-primary_g" onclick="ns.process(<?php echo $ubm_seq_no; ?>);" type="button" id="btnsubmit">Post</button>
                <button class="pure-button pure-button-primary_r" onclick="ns.remove(<?php echo $ubm_seq_no; ?>);" type="button" id="btndelete">Remove</button>
            </td>
        </tr>
            <?php $y++;
        }
        $stmt->close();
        $db->close();
        ?>
    </tbody>
</table>
<script type="text/javascript">
    var namespace;
    namespace = {
        batch : function() {
            location.href = "home.php?mod=v2&app=44m5c4d4d5e4l4i4a4h564d484";
            return false;
        },
        process : function(id) {
            location.href = "home.php?mod=v2&app=44m5c4d4d5e4l4i4a4h5l4r4j46454x5o4&id="+id;
            return false;
        },
        remove : function(id) {
            if (confirm("Are you sure you wish to delete this entry?"))
            location.href = "home.php?mod=v2&app=44m5c4d4d5e4l4i4a4h594e4g484k4j5&id="+id;
            return false;
        },
        reset : function(){
            location.href = "home.php?mod=v2&app=44m5c4d4d5e4l4i4a4";
        },
        back : function(){
            location.href = "home.php?mod=v2&app=b4r5446426";
            return false;
        }
    };
    window.ns = namespace;

    $(document).ready(function() {
        $("#search").click( function(){
            $("#form2").attr('action','home.php?mod=v2&app=44m5c4d4d5e4l4i4a4');
            $("#form2").attr('method','post');
            $("#form2").submit();         
        });
    });
</script>
