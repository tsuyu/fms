<form method="post" name="registration_form" class="form-style-1" action="core.php?mod=<?php echo encode("1"); ?>&app=<?php echo encode("register_add"); ?>">
    <table class="pure-table2" width="100%">
        <tbody>
            <tr>
                <td colspan="5" style="padding: 20px;">
                    <ul>
                        <li><b><font size="5">FMS Registration Form</font></b></li>
                        <li>&nbsp;</li>
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
                        <li>&nbsp;</li>
                    </ul>
            <tr>
                <td width="20%" colspan="3" align="right">User Type :<font color="red">*</font></td>
                <td><select name="usertype" id="usertype">
                        <option value="">SELECT</option>
                        <option value="STU">STUDENT</option>
                        <option value="TNT">TENANT</option>
                        <option value="EXT">EXTERNAL</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td width="20%" colspan="3" align="right">Company :</td>
                <td><input type="text" name="name" id="name" class="field-divided" /> if applicable</td>
            </tr>
             <tr>
                <td width="20%" colspan="3" align="right">Project :</td>
                <td><input type="text" name="name" id="name" class="field-divided" /> if applicable</td>
            </tr>
            <tr>
                <td width="20%" colspan="3" align="right">Full Name :<font color="red">*</font></td>
                <td><input type="text" name="name" id="name" class="field-divided" /></td>
            </tr>
            <tr>
                <td width="20%" colspan="3" align="right">Username :<font color="red">*</font></td>
                <td><input type="text" name="username" id="username" class="field-divided" /> username to log in</td>
            </tr>
            <tr>
                <td width="20%" colspan="3" align="right">Lot No / Room No :</td>
                <td><input type="text" name="username" id="username" class="field-divided" /></td>
            </tr>
            <tr>
                <td width="20%" colspan="3" align="right">Phone No :<font color="red">*</font></td>
                <td><input type="text" name="phone" id="phone" class="field-divided"/> sample : 0129123456</td>
            </tr>
            <tr> 
                <td width="20%" colspan="3" align="right">Email :<font color="red">*</font></td>
                <td><input type="text" name="email" id="email" class="field-divided"/> sample: user@user.com</td>
            </tr>
            <tr>     
                <td width="20%" colspan="3" align="right">Password :<font color="red">*</font></td></td>
                <td><input type="password"
                           name="password"
                           id="password"/></td>
            </tr>
            <tr>   
                <td width="20%" colspan="3" align="right">Confirm password :<font color="red">*</font></td>
                <td><input type="password"
                           name="confirmpwd"
                           id="confirmpwd"/></td>
            </tr>
            <tr>
                <td width="20%" colspan="3" align="right"></td>
                <td><button class="pure-button pure-button-primary"
                            onclick="return regformhash(this.form,
                                            this.form.name,
                                            this.form.username,
                                            this.form.email,
                                            this.form.password,
                                            this.form.confirmpwd);" >Register</button>
                    <button class="pure-button pure-button-primary_r" type="button" id="btnclose">Login Page</button>

                </td>
            </tr>
        </tbody></table>
</form>
<script type="text/javascript" src="include/js/jquery.min.js"></script>
<script type="text/javaScript" src="include/js/sha512.js"></script>
<script type="text/javaScript" src="include/js/forms.js"></script>
<script type="text/javascript" language="javascript">
                                $(document).ready(function () {
                                    $("#btnclose").click(function () {
                                        location.href = "index.php";
                                    });
                                });
</script>