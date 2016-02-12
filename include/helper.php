<?php
define(  'ROOT', '/fms');
ini_set( 'error_reporting', E_ALL ^ E_NOTICE );
ini_set( 'date.timezone', 'Asia/Kuala_Lumpur');

/*login credential */
define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "member");
define("SECURE", FALSE);

define('SALT', 'AbCdEfGhIJkLmNoPqRsTuVWxYz0987654321[]{}+=?/><,.&$#@!');

function encode($string) {
    $key = SALT;
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    for ($i = 0; $i < $strLen; $i++) {
        $ordStr = ord(substr($string, $i, 1));
        if ($j == $keyLen) {
            $j = 0;
        }
        $ordKey = ord(substr($key, $j, 1));
        $j++;
        $hash .= strrev(base_convert(dechex($ordStr + $ordKey), 16, 36));
    }
    return $hash;
}

function decode($string) {
    $key = SALT;
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    for ($i = 0; $i < $strLen; $i+=2) {
        $ordStr = hexdec(base_convert(strrev(substr($string, $i, 2)), 36, 16));
        if ($j == $keyLen) {
            $j = 0;
        }
        $ordKey = ord(substr($key, $j, 1));
        $j++;
        $hash .= chr($ordStr - $ordKey);
    }
    return $hash;
}

function sanitize($data) {
    //escapes,strips and trims all members of the post array
    if (is_array($data)) {
        $areturn = array();
        foreach ($data as $skey => $svalue) {
            $areturn[$skey] = sanitize($svalue);
        }
        return $areturn;
    } else {
        if (!is_numeric($data)) {
            //with magic quotes on, the input gets escaped twice, we want to avoid this.
            if (get_magic_quotes_gpc()) { //gets current configuration setting of magic quotes
                $data = stripslashes($data);
            }
            //escapes a string for insertion into the database
            $data = strip_tags($data);  //strips HTML and PHP tags from a string

            $data = preg_replace('/[^-a-zA-Z0-9_]/', '', $data);

            $data = preg_replace('#]*>.*?#is', '', $data); // strips javascript

            $data = preg_replace("/<object[0-9 a-z_?*=\":\-\/\.#\,\\n\\r\\t]+/smi", "", $data); // strips flash

            $data = addslashes($data);
        }

        $data = trim($data);  //trims whitespace from beginning and end of a string

        return $data;
    }
}

function redirect($page, $msg = null) {
    $output = "<script type=\"text/javascript\" language=\"javascript\">";
    if (!empty($msg)) {
        $output .= "alert('" . $msg . "');";
    }
    $output .= "location.href='" . $page . "';</script>";
    echo $output;
}

function msg($msg) {
    echo "<script type=\"text/javascript\">alert('" . $msg . "');</script>";
}

function zero_pad($number, $n) {
    return str_pad((int) $number, $n, "0", STR_PAD_LEFT);
}

function strict_data($value, $type) {
    // short form code available
    if ($type == 'password' || $type == 'p') {
        if (strlen($value) != 32) {
            if (empty($value)) {
                return ("0");
            }
        }
        return(addslashes($value));
    } elseif ($type == 'numeric' || $type == 'n') {
        if (!is_numeric($value)) {
            $value = 0;
            return($value);
        } else {
            return(intval($value));
        }
    } elseif ($type == 'boolean' || $type == 'b') {
        if ($value == 'true') {
            return 1;
        } elseif ($value) {
            return 0;
        }
    } elseif ($type == 'string' || $type == 's') {
        $value = sanitize($value);
        if (empty($value) && (strlen($value) == 0)) {
            $value = " ";
            return($value);
        } elseif (strlen($value) == 0) {
            $value = " ";
            return($value);
        } else {
            $value = trim($value); // trim any space better for searching issue
            return(addslashes(nl2br($value)));
        }
    } elseif ($type == 'wyswyg' || $type == 'w') {
        // just return back
        // addslashes will destroy the code
        return(htmlspecialchars($value));
    } elseif ($type == 'blob') {
        // this is easy for php/mysql developer
        $value = addslashes($value);
        return(htmlspecialchars($value));
    } elseif ($type == 'memo' || $type == 'm') {
        // this is easy for vb/access developer
        $value = addslashes($value);
        return(htmlspecialchars($value));
    } elseif ($type == 'currency') {
        // make easier for vb.net programmer to understand float value
        $value = str_replace("$", "", $value); // filter for extjs if exist
        $value = str_replace(",", "", $value);
        return($value);
    } elseif ($type == 'float' || $type == 'f') {
        // make easier c programmer to understand float value
        $value = str_replace(",", "", $value);
        return($value);
    } elseif ($type == 'date' || $type == 'd') {
        // ext date like this mm/dd yy03/03/07
        // ext date mm/dd/yy mysql date yyyymmdd
        //ext allready validate date at javascript runtime
        // check either the date empty or not if empty key in today value
        if (empty($value)) {
            return(date("Y-m-d"));
        } else {
            $month = substr($value, 0, 2);
            $day = substr($value, 3, 2);
            $year = substr($value, 6, 4);
            return($year . $month . $day);
            //return $year.$month.$day;
        }
    }
}
function output($value) {
    return htmlentities($value, ENT_QUOTES, 'UTF-8');
}
function sql_quote( $value ) {
    if( get_magic_quotes_gpc() ) {
        $value = stripslashes( $value );
    }

    else {
        $value = addslashes( $value );
    }
    return $value;
}

function bcode($table,$db,$fseq_no,$fcode,$fdesc,$order_by = null) {
    // $r_array = array();
    $sql = "SELECT `".$fseq_no."`,`".$fcode."`,`".$fdesc."` FROM `".$table."` WHERE 1 ";
    if($order_by != null){
       $sql .= "ORDER BY ".$order_by." DESC" ;
    }
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $stmt-> bind_result($seq_no,$code,$desc);
    while ($stmt->fetch()) {
        $r_array[] = array($seq_no,$code,$desc);
    }
    $stmt->close();
    $db->close();
    return $r_array;
}

function selected($cparam,$param) {
    if($cparam==$param)return "selected";
}

function is_login() {
    session_start();
    if (!(isset($_SESSION['username']) && $_SESSION['username'] != '')) {
        redirect(ROOT."/index.php");
    }
}

function esc_url($url) {

    if ('' == $url) {
        return $url;
    }

    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;

    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }

    $url = str_replace(';//', '://', $url);

    $url = htmlentities($url);

    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);

    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}

function dumper($v) {
    echo '<pre>';
//var_dump($v);
    print_r($v);
    echo '</pre>';
}

function validateMysqlDate( $date ) {
    if (preg_match("/^(\d{4})-(\d{2})-(\d{2}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $date, $matches)) {
        if (checkdate($matches[2], $matches[3], $matches[1])) {
            return true;
        }
    }
    return false;
}

function menu($module,$db) {
    $sql = "SELECT
`amm_module_code`,
`amm_module_desc`,
`amm_root_app`,
`amm_page_app`,
`amm_li`
FROM
`apps_user_main` JOIN
`apps_system_main` JOIN
`apps_module_main` JOIN
`apps_application_main` JOIN
`apps_user_role` JOIN
`apps_assign_role`
WHERE
`asm_system_code` = 'FM'
AND `aam_application_status` = 'Y'
AND `arr_user_status` = 'Y'
AND `aum_username` = ?
AND `aur_role_code` = `arr_user_role`
AND `aam_application_code` = `arr_user_application`
AND `asm_system_code` = `aam_system_code`
AND `amm_module_code` = `aam_module_code`
AND `aum_role` = `aur_role_code`
ORDER BY `aam_module_code` ASC";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $_SESSION['username']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($amm_module_code,$amm_module_desc,$amm_root_app,$amm_page_app,$amm_li);

    $columns = array();
    while ($stmt->fetch()) {
        $columns[$amm_module_code]['amm_module_desc'] = $amm_module_desc;
        $columns[$amm_module_code]['amm_root_app'] = $amm_root_app;
        $columns[$amm_module_code]['amm_page_app'] = $amm_page_app;
        $columns[$amm_module_code]['amm_li'] = $amm_li;
    }
    $stmt->close();
    $db->close();
    //dumper($columns);
    foreach($columns as $key => $value) {
        if($key == $module) {
            echo "<a href=\"".$value['amm_root_app'].".php?mod=".encode($key)."&app=".encode($value['amm_page_app'])."\"><li class=\"select\">".$value['amm_module_desc']."</li></a>";
        }else {
            echo "<a href=\"".$value['amm_root_app'].".php?mod=".encode($key)."&app=".encode($value['amm_page_app'])."\"><li id=\"".$value['amm_li']."\">".$value['amm_module_desc']."</li></a>";
        }
    }
    echo "<a href=\"\"><li id=\"\"></li></a>";
}

function dmodule($db) {
    $stmt = $db->prepare("SELECT `aur_role_dmodule`
    FROM `apps_user_role`
    JOIN `apps_user_main`
    WHERE aum_role = aur_role_code
    AND `aum_username` = ?
    LIMIT 1");
    $stmt->bind_param("s", $_SESSION['username']);
    $stmt->execute();
    $stmt->bind_result($aur_role_dmodule);
    $stmt->fetch();
    $stmt->close();

    return $aur_role_dmodule;
}
?>
