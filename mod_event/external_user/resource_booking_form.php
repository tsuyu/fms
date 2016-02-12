<form id="form1" action="">
    <table class="pure-table2" width="100%">
        <thead>
        </thead>
        <tbody>
            <tr class = "pure-table2-odd">
                <td colspan="4"><b>Apply Resource Booking</b><input type="hidden" name="location_id" value="<?php echo $_GET['id'];?>"/></td>
            </tr>
            <tr>
                <td width="20%" colspan="3" align="right">From (Date)</td>
                <td><select name="day_from">
                        <?php
                        for($x = 1; $x <= 31; $x++) {
                            echo "<option value=\"".zero_pad($x, 2)."\">".zero_pad($x, 2)."</option>";
                        }
                        ?>
                    </select>
                    <select name="month_from">
                        <?php
                        for($y = 1; $y <= 12; $y++) {
                            echo "<option value=\"".zero_pad($y, 2)."\">".zero_pad($y, 2)."</option>";
                        }
                        ?>
                    </select>
                    <select name="year_from">
                        <?php
                        $currently_selected = date('Y');
                        $earliest_year = 2014;
                        $latest_year = date('Y', strtotime('+1 years'));
                        foreach ( range( $latest_year, $earliest_year ) as $i ) {
                            //echo $i;
                            print '<option value="'.$i.'"'.($i == $currently_selected ? ' selected="selected"' : '').'>'.$i.'</option>';
                        }
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td colspan="3" align="right">(Time)</td>
                <td><select name="timeh_from">
                        <?php
                        for($x = 0; $x <= 23; $x++) {
                            echo "<option value=\"".zero_pad($x, 2)."\">".zero_pad($x, 2)."</option>";
                        }
                        ?>
                    </select>&nbsp;:&nbsp;
                    <select name="timem_from">
                        <?php
                        for($x = 0; $x <= 45; $x += 15) {
                            echo "<option value=\"".zero_pad($x, 2)."\">".zero_pad($x, 2)."</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="4" align="right">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3" align="right">To (Date)</td>
                <td><select name="day_to">
                        <?php
                        for($x = 1; $x <= 31; $x++) {
                            echo "<option value=\"".zero_pad($x, 2)."\">".zero_pad($x, 2)."</option>";
                        }
                        ?>
                    </select>
                    <select name="month_to">
                        <?php
                        for($y = 1; $y <= 12; $y++) {
                            echo "<option value=\"".zero_pad($y, 2)."\">".zero_pad($y, 2)."</option>";
                        }
                        ?>
                    </select>
                    <select name="year_to">
                        <?php
                        $currently_selected = date('Y');
                        $earliest_year = 2014;
                        $latest_year = date('Y', strtotime('+1 years'));
                        foreach ( range( $latest_year, $earliest_year ) as $i ) {
                            echo $i;
                            print '<option value="'.$i.'"'.($i == $currently_selected ? ' selected="selected"' : '').'>'.$i.'</option>';
                        }
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td colspan="3" align="right">(Time)</td>
                <td><select name="timeh_to">
                        <?php
                        for($x = 0; $x <= 23; $x++) {
                            echo "<option value=\"".zero_pad($x, 2)."\">".zero_pad($x, 2)."</option>";
                        }
                        ?>
                    </select>&nbsp;:&nbsp;
                    <select name="timem_to">
                        <?php
                        for($x = 0; $x <= 45; $x += 15) {
                            echo "<option value=\"".zero_pad($x, 2)."\">".zero_pad($x, 2)."</option>";
                        }
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td colspan="4" align="right">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3" align="right">Reason</td>
                <td><textarea cols="40" rows="8" name="reason"></textarea></td>
            </tr>
            <tr>
                <td colspan="3" align="right">&nbsp;</td>
                <td colspan="3" align="left">
                    <button class="pure-button pure-button-primary" type="submit" id="btnsubmit">Submit</button>
                    <button  onclick="return ns.back(<?php echo $_GET['id'];?>);" class="pure-button pure-button-primary_r" type="button" id="btnclose">Back</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>
<script type="text/javascript">

    var namespace;
    namespace = {
        back : function(id){
            location.href = "home.php?mod=u2&app=k4i5j4g4z5p464e454k5k4o4f4c4e4l54464c4k4i5m5u5&id="+id;
        }
    };
    window.ns = namespace;

    $(document).ready(function(){

        $('#btnsubmit').click(function(event) {
             $("#form1").attr('action','home.php?mod=u2&app=k4i5j4g4z5p464e454k5k4o4f4c4e4l54484m4i4u5c516h5r4m5');
             $("#form1").attr('method','post');
             $("#form1").submit();
        });

    });
</script>
