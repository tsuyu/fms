<?php
//ob_start();
require_once 'include/helper.php';
require_once 'include/path.php';
require_once 'include/paging.php';
require_once 'class.adapter.php';
require_once 'session.php';

$session = new session();
// Set to true if using https
$session->start_session('_s', false);

$mod = decode($_GET['mod']);
$app = decode($_GET['app']);

if(!isset($_GET['mod'])&&!isset($_GET['app'])) {
   $path = $map_path[$aur_role_dmodule]['page']['index'];
}else {
   $path = $map_path[$mod]['page'][$app];
}
?>
<!doctype html><html  lang="en">

    <head>
        <link href="include/css/reset.css" rel="stylesheet" type='text/css' media="all" />
        <link href="include/css/form.css" rel='stylesheet' type='text/css' />
        <link href="include/css/buttons.css" rel='stylesheet' type='text/css' />
        <link href="include/css/grid.css" rel="stylesheet" type="text/css" />
        <link href="include/css/pure_table.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="include/js/jquery.min.js"></script>
        <title></title>
    </head>
    <body>
        <?php
        if (isset($path)) {
            if ($path != '') {
                require_once $path;
            }else {
                redirect("not_found.php");
            }
        }else {
            redirect("not_found.php");
        }
        ?>
    </body>
</html>