<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/
require_once 'include/helper.php';
require_once 'class.adapter.php';
require_once 'session.php';

$session = new session();
$session->start_session('_s', false);

if(isset($_SESSION['username'])){
    unset($_SESSION['username']);
    session_destroy();
}
?>
<!doctype html>
<html  lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>UMP Services System</title>
        <link href="include/css/login_style.css" rel="stylesheet" type="text/css"/>
        <script type="text/javaScript" src="include/js/sha512.js"></script>
        <script type="text/javaScript" src="include/js/forms.js"></script></head>
    <body class="profile-login">
    <header class="global-header">
    </header>
    <section class="login">
        <h1><img width="150" title="" alt="" src="include/img/logo-umps.png"/></h1>
        <form id="login-form" accept-charset="utf-8" method="post" action="core.php?mod=<?php echo encode("1"); ?>&app=<?php echo encode("process_login"); ?>">
            <h1>UMP Services System</h1>
            <input type="text" value="" placeholder="Username" tabindex="20" name="username"/>
            <div class="password-container">
                <input type="password" placeholder="Password" tabindex="21" name="password" id="password"/>
            </div>
            <table border="0" width="100%">
                <tr><td width="50%">
                        <span class="create-account">
                            <a data-analytics="create-account" href="core.php?mod=<?php echo encode("1"); ?>&app=<?php echo encode("register"); ?>">Create an Account</a>
                        </span>
                    </td>

                    <td align="right" width="50%">
                        <button class="button submit" id ="sign-in" data-analytics="sign-in" type="button" onclick="formhash(this.form, this.form.password);">Log In</button>

                    </td>
                </tr>
            </table>
        </form>
    </section>
</body>
</html>
