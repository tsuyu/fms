<form id="form1" action="">
    <table class="pure-table2" width="100%">
        <thead>
        </thead>
        <tbody>
            <tr class = "pure-table2-odd">
                <td colspan="4"><b>Add New Batch</b></td>
            </tr>

            <tr>
                <td width="20%" colspan="3" align="right">Batch (No)</td>
                <td><select name="batchno_day">
                        <?php
                        for($x = 1; $x <= 12; $x++) {
                            echo "<option value=\"".zero_pad($x, 2)."\">".zero_pad($x, 2)."</option>";
                        }
                        ?>
                    </select>&nbsp;/&nbsp;
                    <select name="batchno_year">
                        <?php
                        $currently_selected = date('Y');
                        $earliest_year = 2014;
                        $latest_year = date('Y', strtotime('+1 years'));
                        foreach ( range( $latest_year, $earliest_year ) as $i ) {
                            echo $i;
                            print '<option value="'.$i.'"'.($i == $currently_selected ? ' selected="selected"' : '').'>'.$i.'</option>';
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td width="20%" colspan="3" align="right">Batch (Date To)</td>
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
                            echo "<option ".zero_pad($y, 2).">".zero_pad($y, 2)."</option>";
                        }
                        ?>
                    </select>
                    <select name="year_from">
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
                <td width="20%" colspan="3" align="right">Batch (Date From)</td>
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
                            echo "<option ".zero_pad($y, 2).">".zero_pad($y, 2)."</option>";
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
                <td colspan="3" align="right">&nbsp;</td>
                <td colspan="3" align="left">
                    <button class="pure-button pure-button-primary" type="submit" id="btnsubmit">Submit</button>
                    <button  onclick="return ns.back();" class="pure-button pure-button-primary_r" type="button" id="btnclose">Back</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>
<script type="text/javascript">

    var namespace;
    namespace = {
        back : function(id){
            location.href = "home.php?mod=v2&app=44m5c4d4d5e4l4i4a4";
        }
    };
    window.ns = namespace;

    $(document).ready(function(){

        $('#btnsubmit').click(function(event) {
            $("#form1").attr('action','home.php?mod=v2&app=44m5c4d4d5e4l4i4a4h564d48424j4f5r474');
            $("#form1").attr('method','post');
            $("#form1").submit();
        });

    });
</script>