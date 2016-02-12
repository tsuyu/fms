<table class="pure-table2" width="100%">
    <thead>
    </thead>
    <tbody>
        <?php
        //echo encode("resource_booking_form_save");
        $db = MySQL::getInstance();
        $stmt = $db->prepare("SELECT `aum_username`,`aum_name`,`aum_email`, `aum_phone` FROM `apps_user_main`
                WHERE 1 AND `aum_username` = ? ");
        $stmt->bind_param("s", $_SESSION['username']);
        $stmt->execute();
        $stmt-> bind_result($aum_username,$aum_name,$aum_email,$aum_phone);
        while ($stmt->fetch()) {
            ?>
        <tr class = "pure-table2-odd">
            <td colspan="2"><b>MAKLUMAT PEMOHON /</b><i>PERSONAL  PARTICULARS</i></td>

        </tr>
        <tr>
            <td width="15%">ID-Nama/ <i><br>
                    ID-Name</i></td>
            <td><?php echo $aum_username."-".$aum_name; ?></td>
        </tr>
        <tr>
            <td width="15%">No Telefon/ <i><br>
                    Phone No</i></td>
            <td><?php echo $aum_phone; ?></td>
        </tr>
        <tr>
            <td width="15%">Email/ <i><br>
                    Email</i></td>
            <td><?php echo $aum_email; ?></td>
        </tr>
            <?php } ?>
    </tbody>
</table>
<br/>
<table class="pure-table2" width="100%">
    <thead>
    </thead>
    <tbody>
        <tr  class = "pure-table2-odd">
            <td colspan="2"><b>PERATURAN AM /</b><i>RULES AND REGULATION</i></td>
        </tr>
        <tr>
            <td width="5%">(i)</td>
            <td>
                Semua pengguna adalah bertanggungjawab menjaga keselamatan, kebersihan dan memastikan suis lampu
                dan penghawa dingin ditutup selepas digunakan.</td>
        </tr>
        <tr>
            <td>(ii)</td>
            <td>PERINGATAN : <b> Universiti Adalah </b> KAWASAN LARANGAN MEROKOK</td>
        </tr>
        <tr>
            <td>(iii)</td>
            <td></td>
        </tr>
        <tr>
            <td>(iv)</td>
            <td></td>
        </tr>
        <tr>
            <td>(v)</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2"><br/>
                <form name="form1" id="form1" action="">
                    <div style="padding-left: 20px;">
                        <input name="check" type="checkbox" id="check" value="Ya">
                        <b> Ya</b>, saya setuju dengan syarat dan terma berkenaan.</div>
                    <div style="padding-left: 20px;"><br/>
                        <button class="pure-button pure-button-primary" id="next">Next</button>
                        <button class="pure-button pure-button-primary_r" id="cancel">Cancel</button>
                    </div>
                </form>
            </td>
        </tr>
    </tbody>
</table>
<script type="text/javascript">

    $(document).ready(function(){
        $("#next").click( function(){
            if($("#check").prop('checked') == true){
                $("#form1").attr('action','home.php?mod=u2&app=k4i5j4g4z5p464e454k5k4o4f4c4e4l544e4m434i5x5r5v5j4');
                $("#form1").attr('method','post');
                $("#form1").submit();
                return true;
            }else{
                alert("You must accept term and condition before proceed!");
                return false;
            }
        });
        $("#cancel").click(function(){
            location.href = "home.php?mod=u2&app=b4r5446426";
            return false;
        });
    });
</script>