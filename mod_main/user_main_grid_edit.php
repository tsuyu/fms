<?php
$scode = bcode('apps_user_role',MySQL::getInstance(),'aur_seq_no','aur_role_code','aur_role_desc');
?>
<!-- Registration form to be output if the POST variables are not
set or if the registration script caused an error. -->
<h2 id="p_title" style="padding-bottom: 10px;padding-left: 20px;">Edit User</h2>

<form method="post" name="registration_form"  class="form-style-1" action="home.php?mod=<?php echo encode("1"); ?>&app=<?php echo encode("user_main_grid_edit_save"); ?>&id=<?php echo $_GET['id']; ?>">
    <?php
    $db = MySQL::getInstance();
    $stmt = $db->prepare("SELECT `aum_seq_no`,`aum_name`,`aum_username`,`aum_phone`,`aum_email`,`aum_role` FROM `apps_user_main` WHERE 1 AND
                `aum_seq_no` = ? ");
    $stmt->bind_param("s", decode($_GET['id']));
    $stmt->execute();
    $stmt->bind_result($aum_seq_no,$aum_name,$aum_username,$aum_phone,$aum_email,$aum_role);
    $stmt->fetch();
    $stmt->close();
    $db->close();
    ?>
    <table class="pure-table2" width="100%">
        <thead>
        </thead>
        <tbody>
            <tr>
                <td colspan="5" style="padding: 20px;">
                    <ul>
                        <li>1. Usernames may contain only digits, upper and lower case letters and underscores.</li>
                        <li>2. Emails must have a valid email format.</li>
                        <li>3. Passwords must be at least 6 characters long.</li>
                        <li>4. Passwords must contain :
                            <div style="padding-left: 20px; font-weight: bold">
                                <ul>
                                    <li>At least one upper case letter (A..Z).</li>
                                    <li>At least one lower case letter (a..z).</li>
                                    <li>At least one number (0..9).</li>
                                </ul>
                            </div>
                        </li>
                        <li>5. Your password and confirmation must match exactly.</li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td width="20%" colspan="3" align="right">Full Name :</td>
                <td><input type="text" name="name" id="name" value="<?php echo $aum_name;?>" class="field-divided" /></td>
            </tr>

            <tr>
                <td width="20%" colspan="3" align="right">Username :</td>
                <td><input type="text" name="username" id="username" disabled value="<?php echo $aum_username;?>" class="field-divided" />
                </td>

            </tr>
            <tr>
                <td width="20%" colspan="3" align="right">Phone No :</td>
                <td><input type="text" name="phone" id="phone" value="<?php echo $aum_phone;?>"/></td>
            </tr>
            <tr>
                <td width="20%" colspan="3" align="right">Email :</td>
                <td><input type="text" name="email" id="email" value="<?php echo $aum_email;?>"/></td>

            </tr>
            <tr>
                <td width="20%" colspan="3" align="right">Role :</td>
                <td><select name="role" id="slctrole">
                        <?
                        $strole  = "<option value=\"\">SELECT</option>\n";
                        for($i=0;$i<count($scode);$i++) {
                            $strole .= "<option value=\"".$scode[$i][1]."\" ".selected($scode[$i][1],$aum_role).">".$scode[$i][2]."</option>\n";
                        }
                        echo $strole;
                        ?>
                    </select></td>

            </tr>
            <tr>
                <td width="20%" colspan="3" align="right"></td>
                <td><input type="checkbox" name="chkreset"> &nbsp; Reset Password</td>
            </tr>
            <tr>
                <td width="20%" colspan="3" align="right">Password :</td>
                <td><input type="password"
                           name="password"
                           id="password"/></td>


            </tr>
            <tr>
                <td width="20%" colspan="3" align="right">Confirm password :</td>
                <td><input type="password"
                           name="confirmpwd"
                           id="confirmpwd"/></td>
            </tr>
            <tr>
                <td width="20%" colspan="3" align="right"></td>
                <td>
                    <button class="pure-button pure-button-primary"
                            onclick="return regformhash2(this.form,
                                                                      this.form.username,
                                                                      this.form.email,
                                                                      this.form.password,
                                                                      this.form.confirmpwd,
                                                                      this.form.chkreset);" >Update</button>
                    <button class="pure-button pure-button-primary_r" type="button" id="btnclose">Back</button></td>
        </tbody>
    </table>
</form> 
<script type="text/JavaScript" src="include/js/sha512.js"></script>
<script type="text/JavaScript" src="include/js/forms.js"></script>
<script type="text/javascript" language="javascript">
    $(document).ready(function(){
        $("#btnclose").click( function(){
            location.href = "home.php?mod=r2&app=n4w554j4d5k444i4k4h5c4r4d474";
        });
    });
</script>