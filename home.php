<?php
//ob_start();
require_once 'include/helper.php';
require_once 'include/path.php';
require_once 'include/paging.php';
require_once 'class.adapter.php';
require_once 'session.php';
require_once 'include/shoutbox/database.php';

$session = new session();
$session->start_session('_s', false);

$mod = decode($_GET['mod']);
$app = decode($_GET['app']);

if (isset($_SESSION['username'])) {
    $dmodule = dmodule(MySQL::getInstance());

    if (!isset($_GET['mod']) && !isset($_GET['app'])) {
        $path = $map_path[$dmodule]['page']['index'];
    } else {
        $path = $map_path[$mod]['page'][$app];
    }
} else {
    redirect("not_found.php");
}
?>
<!doctype html><html  lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=10; IE=9; IE=8; IE=7; IE=EDGE" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> <?php
            if (!isset($_GET['mod']) && !isset($_GET['app'])) {
                echo $map_path[$dmodule]['title'];
            } else {
                echo $map_path[decode($_GET['mod'])]['title'];
            }
            ?></title>
        <link rel="stylesheet" href="include/css/reset.css" type='text/css' media="all" />
        <link rel="stylesheet" href="include/css/style.css" type='text/css' media="all" />
        <link rel="stylesheet" href="include/shoutbox/css/style.css" type='text/css' media="all" />
        <link rel="stylesheet" href="include/css/tabs.css" type='text/css'/>
        <link rel="stylesheet" href="include/css/buttons.css" type='text/css'/>
        <link rel="stylesheet" href="include/js/dhtmlmodal/windowfiles/dhtmlwindow.css" type="text/css" />
        <link rel="stylesheet" href="include/css/paging.css" type="text/css" />
        <link rel="stylesheet" href="include/css/accordion.css" type="text/css" />
        <link rel="stylesheet" href="include/js/lightbox/css/lightbox.css"  type="text/css"  media="screen" />
        <link rel="stylesheet" href="include/css/grid.css" type="text/css" />
        <link rel="stylesheet" href="include/css/jquery-ui.css" type="text/css" />
        <link rel="stylesheet" href="include/css/jquery-ui.structure.css" type="text/css" />
        <link rel="stylesheet" href="include/css/jquery-ui.theme.css" type="text/css" />
        <script type="text/javascript" src="include/js/dhtmlmodal/windowfiles/dhtmlwindow.js"></script>
        <script type="text/javascript" src="include/js/jquery.min.js"></script>
        <script type="text/javascript" src="include/js/jquery-accordian.min.js"></script>
        <script type="text/javascript" src="include/js/jquery.combo.select.js"></script>
        <script type="text/javascript" src="include/js/validation.js"></script>
        <script type="text/javascript" src="include/shoutbox/js/script.js"></script>
        <script type="text/javascript" src="include/js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="include/js/stupidtable.min.js"></script>
        <script type="text/javascript" src="include/timeout/store.js"></script>
        <script type="text/javascript" src="include/timeout/jquery-idleTimeout.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                //$('.sidebarmenu,.image').data("hidden", !hidden);
                $("#showmenu").click(function () {
                    var e = $(".sidebarmenu").data("hidden");
                    e ? ($(".sidebarmenu").animate({left: "0px"}, 500), $("#right").animate({marginLeft: "204px"}, 500)) : ($(".sidebarmenu").animate({left: "-200px"}, 500), $("#right").animate({marginLeft: "0px"}, 500)), $(".sidebarmenu,.image").data("hidden", !e)
                }), $(document).idleTimeout({redirectUrl: "/fms/index.php", idleTimeLimit: 600, idleCheckHeartbeat: 2, customCallback: !1, activityEvents: "click keypress scroll wheel mousewheel mousemove", enableDialog: !0, dialogDisplayLimit: 20, dialogTitle: "Session Expiration Warning", dialogText: "Because you have been inactive, your session is about to expire.", dialogTimeRemaining: "Time remaining", dialogStayLoggedInButton: "Stay Logged In", dialogLogOutNowButton: "Log Out Now", errorAlertMessage: 'Please disable "Private Mode", or upgrade to a modern browser. Or perhaps a dependent file missing.', sessionKeepAliveTimer: 600, sessionKeepAliveUrl: window.location.href});


            });
            function openProfile() {
                location.href = "home.php?mod=r2&app=n4w554j4d5k444i4k4h5c4r4d474";
            }

            function logOut() {
                location.href = "index.php";
            }

            $(function () {
                $("table").stickyTableHeaders();
            });
        </script>
        <script type="text/javascript" src="include/js/dhtmlmodal/windowfiles/dhtmlwindow.js"></script>
        <!--[if !IE 7]>
                <style type="text/css">
                #wrap {display:table;height:100%}
        </style>
        <![endif]-->
        <script type="text/javascript" src="include/js/dhtmlmodal/modalfiles/modal.js"></script>
    </head>
    <body>
        <div id="container">
            <div id="left" class="sidebarmenu">
                <div id="logo">
                    <div class="dummy"></div>
                    <div class="img-container">
                        <img src="include/img/Face.png"/>
                    </div>
                </div>
                <div id="tools">
                    <?php
                    if ($_GET['mod'] == '' && !isset($_GET['mod'])) {
                        menu(strict_data($dmodule, 'numeric'), MySQL::getInstance());
                    } else if ($_GET['mod'] != '' && isset($_GET['mod'])) {
                        menu(strict_data(decode($_GET['mod']), 'numeric'), MySQL::getInstance());
                    } else {
                        redirect("not_found.php");
                    }
                    ?>
                </div>
                <div id="sb">
                    <div id="shouts">
                        <ul>
                            <?php
                            $sql = "SELECT `asm_name`,`asm_message`,DATE_FORMAT(`asm_time`,'%d-%m-%y %h:%i %p') as `asm_time` FROM `apps_shoutbox_main` ORDER BY `asm_time` DESC LIMIT 20";
                            $query = mysqli_query($connection, $sql);
                            while ($row = mysqli_fetch_assoc($query)) {
                                ?>
                                <li><?php echo "<b>" . $row['asm_name'] . "</b> : " . $row['asm_message'] . " [ " . $row['asm_time'] . " ] " ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <br/>
                    <form>
                        <input type="text" id="shout" style="border:1px solid #BEBEBE;height: 25px;" placeholder="Message here">
                        <input type="button" id="submit" value="SHOUT!" >
                    </form>
                </div>
            </div>
            <div id="right">
                <div id="header">
                    <div id="plus">
                        <a href="#" id="showmenu">
                            <span id="arti"></span>
                        </a>
                    </div>
                    <div id="f_right2">
                        <ul>
                            <li>
                                <a href="#" onClick="openProfile();
                return false;" ><span id="user"><font>Logged in as <b><?php echo output($_SESSION['username']); ?></b></font></span></a>
                            </li>
                            <li >
                                <a href="#"><span id="setting"></span></a>
                            </li>
                            <li><a href="#" onClick="logOut()
                                            ;
                                    return false;"><span id="exit"></span></a></li>
                        </ul>
                    </div>
                </div>
                <div id="body">
                    <?php
                    if (isset($path)) {
                        if ($path != '') {
                            require_once $path;
                        } else {
                            redirect("not_found.php");
                        }
                    } else {
                        redirect("not_found.php");
                    }
                    ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div id="footer">
            <p>&copy; <?php echo date('Y'); ?> All Rights Reserved<b> UMP Services Sdn. Bhd.</b></p>
        </div>
    </body>
</html>