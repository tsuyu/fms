<?php
$mod = 5;
$db = MySQL::getInstance();
$sql = "SELECT
`amm_module_code`,
`amm_root_app`,
`aam_application_desc`,
`aam_parent_desc`,
`aam_path`,
`aam_icon`
FROM
`apps_user_main` JOIN
`apps_system_main` JOIN
`apps_module_main` JOIN
`apps_application_main` JOIN
`apps_user_role` JOIN
`apps_assign_role`
WHERE
`asm_system_code` = 'FM'
AND `aum_username` = ?
AND `amm_module_code` = ?
AND `aam_application_status` = 'Y'
AND `arr_user_status` = 'Y'
AND `aur_role_code` = `arr_user_role`
AND `aam_application_code` = `arr_user_application`
AND `asm_system_code` = `aam_system_code`
AND `amm_module_code` = `aam_module_code`
AND `aum_role` = `aur_role_code`
ORDER BY `aam_qeueu` ASC";

$stmt = $db->prepare($sql);
$stmt->bind_param("si", $_SESSION['username'],$mod);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($amm_module_code,$amm_root_app,$aam_application_desc,$aam_parent_desc,$aam_path,$aam_icon);

$columns = array();
$a = 1;
while ($stmt->fetch()) {
    $columns[$aam_parent_desc][$a]['amm_module_code'] = $amm_module_code;
    $columns[$aam_parent_desc][$a]['amm_root_app'] = $amm_root_app;
    $columns[$aam_parent_desc][$a]['aam_application_desc'] = $aam_application_desc;
    $columns[$aam_parent_desc][$a]['aam_path'] = $aam_path;
    $columns[$aam_parent_desc][$a]['aam_icon'] = $aam_icon;
    $a++;
}

$stmt->close();
$db->close();

//dumper($columns);

foreach($columns as $key => $value) {
    echo "<h2 id=\"p_title\" style=\"padding-bottom: 20px;\">".$key."</h2>";
    echo "<table border=\"0\"><tr>";
    $i = 1;
    $j = 1;
    foreach($value as $key2 => $value2) {
        if( $i < 8){
        ?>
<td>
    <div class="shortcutHome">
        <a href="<?php echo $value2['amm_root_app']; ?>.php?mod=<?php echo encode($value2['amm_module_code']); ?>&app=<?php echo encode($value2['aam_path']); ?>"><img src="include/img/48/<?php echo $value2['aam_icon']; ?>"/><br/><?php echo $value2['aam_application_desc']; ?></a>
    </div>
</td>
            <?php
        }
        $i++;
    }
    echo "</tr></table><br/><table border=\"0\"><tr>";
    foreach($value as $key2 => $value2) {

        if( $j > 7 && $j < 15){
        ?>
<td>
    <div class="shortcutHome">
        <a href="<?php echo $value2['amm_root_app']; ?>.php?mod=<?php echo encode($value2['amm_module_code']); ?>&app=<?php echo encode($value2['aam_path']); ?>"><img src="include/img/48/<?php echo $value2['aam_icon']; ?>"/><br/><?php echo $value2['aam_application_desc']; ?></a>
    </div>
</td>
            <?php

        }
   $j++;
    }
  echo "</tr></table><br/>";
  }
?>