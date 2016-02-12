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
if(isset($_POST['mode']) && !empty ($_POST['mode'])) {
    $from = strtotime($year_from."-".$month_from."-".$day_from." 00:00:00");
    $to = strtotime($year_to."-".$month_to."-".$day_to." 23:59:00");
}
//dumper($_POST)
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
                <td>Start Date</td><td><select name="day_from">
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
                <td>End Date</td><td><select name="day_to">
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
                    <button class="pure-button pure-button-primary_r" onclick="ns.reset(); return false" type="button" id="btnsubmit">Reset</button>
                    <button name="search" class="pure-button pure-button-primary_g" onclick="book(); return false" type="button" id="search">Search</button></td>
                <td width="30%"></td>
            </tr>
        </tbody>
    </table>
</form>
<br/>
<div align="right">
    <button class="pure-button pure-button-primary" onclick="ns.back(); return false" type="button" id="btnsubmit">Back</button>
</div>
<br/>
<table class="pure-table" width="100%">
    <thead>
        <tr style="border-bottom: 1px solid #cbcbcb;">
            <th width="5%">No</th>
            <th colspan="2">From</th>
            <th colspan="2">To</th>
            <th>Booked By</th>
            <th>Status</th>
            <th>Purpose</th>
        </tr>
        <tr >
            <th></th>
            <th>Date</th>
            <th>Time</th>
            <th>Date</th>
            <th>Time</th>
            <th></th>
            <th></th>
            <th></th>

        </tr>
    </thead>
    <tbody>
        <?php
        $y = 1;
        $db = MySQL::getInstance();
        $sql = "SELECT DATE_FORMAT(`ebm_from_date`,'%d-%m-%Y'),TIME_FORMAT(`ebm_from_date`, '%h:%i%p'),DATE_FORMAT(`ebm_to_date`,'%d-%m-%Y'),TIME_FORMAT(`ebm_to_date`, '%h:%i%p'),`aum_name`, `ebm_purpose`,`ebm_status`
                FROM `event_booking_main` JOIN `apps_user_main` JOIN `location_main_detail` WHERE 1
                AND `aum_username` = `ebm_requestor_id` AND `ebm_location_id` = `lmd_seq_no` AND `ebm_requestor_id` = ? ";
        if(isset($from) && !empty ($to)) {
            $sql .=" AND UNIX_TIMESTAMP(`ebm_from_date`) >= '".$from."'
                     AND UNIX_TIMESTAMP(`ebm_to_date`) <= '".$to."' ";
        }
        $sql .=" ORDER BY `ebm_from_date` DESC ";
        $stmt = $db->prepare($sql);

        $stmt->bind_param("i", $_SESSION['username']);
        $stmt->execute();
        $stmt-> bind_result($ebm_from_date,$ebm_from_time,$ebm_to_date,$ebm_to_time,$aum_name,$ebm_purpose,$ebm_status);
        while ($stmt->fetch()) {
            if ($y % 2 == 0) {
                $odd = 'class = "pure-table-odd"';
            }else {
                $odd = "";
            }
            ?>
        <tr <?php echo $odd;?>>
            <td><?php echo $y; ?></td>
            <td><?php echo output($ebm_from_date);?></td>
            <td><?php echo output($ebm_from_time);?></td>
            <td><?php echo output($ebm_to_date);?></td>
            <td><?php echo output($ebm_to_time);?></td>
            <td><?php echo output($aum_name);?></td>
            <td><?php echo output($ebm_status);?></td>
            <td><?php echo output($ebm_purpose);?></td>
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
        reset : function(){
            location.href = "home.php?mod=u2&app=k4i5j4g4z5p464e454k5k4o4f4c4e4l544l4r41416y516";
        },
        back : function(){
            location.href = "home.php?mod=u2&app=b4r5446426";
        }
    };
    window.ns = namespace;

    $(document).ready(function() {
        $("#search").click( function(){
            $("#mode").val("search");
            $("#form2").attr('action','home.php?mod=u2&app=k4i5j4g4z5p464e454k5k4o4f4c4e4l544l4r41416y516');
            $("#form2").attr('method','post');
            $("#form2").submit();
        });
    });
</script>