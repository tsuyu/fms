<script type="text/javascript">

    function view_asset_edit(id,ipp,page){

        location.href='home.php?mod=s2&app=o4m554o4d584m4s4b42644e484c4k4&id='+id+"&page="+page+"&ipp="+ipp;
    }


    function view_asset_delete(id,ipp,page)
    {
        if (confirm("Are you sure you wish to delete this entry?"))
            location.href='mod_asset/view_asset_delete.php?id='+id+"&page="+page+"&ipp="+ipp;
    }

    function print_barcode(id)
    {
        alert(id);
    }

    $(document).ready(function() {

        $("#view_asset_add").click( function(){
            location.href = "home.php?mod=s2&app=o4m554o4d584m4s4b42644a48474";
            /* var vaawindow=dhtmlwindow.open('vaawindow', 'iframe', 'mod_asset/view_asset_add.php',
            'Add Asset', 'width=400px,height=200px,center=1,resize=0,scrolling=1');

            vaawindow.onclose=function(){ //Define custom code to run when window is closed
                window.location.reload();
                return true;
            }*/
        });

        $("#back").click( function(){
            location.href = "home.php?mod=s2&app=b4r5446426";
        });

        $("#delete_selected").click( function(){
            $("#form2").attr('action','mod_asset/view_asset_delete_selected.php?page='+$("#page").val()+'&ipp='+$("#ipp").val());
            $("#form2").attr('method','post');
            $("#form2").submit();
        });

        $("#search").click( function(){
            $("#form1").attr('action','home.php?mod=s2&app=o4m554o4d584m4s4b42644g4m4c444&page='+$("#page").val()+'&ipp='+$("#ipp").val());
            $("#form1").attr('method','post');
            $("#form1").submit();
        });

        $("#cleare").click( function(){
            location.href = "home.php?mod=s2&app=o4m554o4d584m4s4b42644g4m4c444";
        });

        $('#selecctall').click(function(event) {  //on click
            if(this.checked) { // check select status
                $('.checkbox1').each(function() { //loop through each checkbox
                    this.checked = true;  //select all checkboxes with class "checkbox1"
                });
            }else{
                $('.checkbox1').each(function() { //loop through each checkbox
                    this.checked = false; //deselect all checkboxes with class "checkbox1"
                });
            }
        });
    });
</script>
<?
//echo encode("view_asset_upload_delete");
//$barcode = array($ab_campus_code);

$ccode = bcode('campus_main',MySQL::getInstance(),'cm_seq_no','cm_campus_code','cm_campus_desc');
$acode = bcode('area_main',MySQL::getInstance(),'arm_seq_no','arm_area_code','arm_area_desc');
$bcode = bcode('building_main',MySQL::getInstance(),'bm_seq_no','bm_building_code','bm_building_desc');
$lcode = bcode('building_level_main',MySQL::getInstance(),'blm_seq_no','blm_level_code','blm_level_desc');
$tcode = bcode('asset_type_code',MySQL::getInstance(),'atc_seq_no','atc_type_code','atc_type_desc');
$scode = bcode('location_main',MySQL::getInstance(),'lm_seq_no','lm_code','lm_name');
$ocode = bcode('location_main_detail',MySQL::getInstance(),'lmd_seq_no','lmd_code','lmd_name');

if(isset($_POST['taggingstatus']) && !empty ($_POST['taggingstatus'])) {
    $am_tagging_status = sanitize($_POST['taggingstatus']);
}
if(isset($_POST['assetno']) && !empty ($_POST['assetno'])) {
    $am_asset_no = sanitize($_POST['assetno']);
}
if(isset($_POST['campus']) && !empty ($_POST['campus'])) {
    $ab_campus_code = sanitize($_POST['campus']);
}
if(isset($_POST['area']) && !empty ($_POST['area'])) {
    $ab_area_code = sanitize($_POST['area']);
}
if(isset($_POST['building']) && !empty ($_POST['building'])) {
    $ab_building_code = sanitize($_POST['building']);
}
if(isset($_POST['level']) && !empty ($_POST['level'])) {
    $ab_level_code = sanitize($_POST['level']);
}
if(isset($_POST['type']) && !empty ($_POST['type'])) {
    $ab_type_code = sanitize($_POST['type']);
}
if(isset($_POST['system']) && !empty ($_POST['system'])) {
    $ab_system_code = sanitize($_POST['system']);
}
if(isset($_POST['other']) && !empty ($_POST['other'])) {
    $ab_other_code = sanitize($_POST['other']);
}
?>
<div class="table-container">
    <h2 id="p_title" style="padding-bottom: 25px;">View Asset</h2>
    <form name="form1" id="form1">
        <input type="hidden" id="ipp" name="ipp" value="<?php echo $_GET['ipp'];?>" />
        <input type="hidden" id="page" name="page" value="<?php echo $_GET['page'];?>" />
        <div style="padding-bottom: 20px;font-size:13px;">
            <label for="name" style=" font-weight: bolder;">Asset No :</label>
            <input type="text"  style="border:1px solid #BEBEBE;padding: 7px;margin:0px;height:17px;" id="txtsearchassetno" maxlength="19"  size="40" name="assetno" value="<?php echo $am_asset_no; ?>" class="field-long"/>
            <button class="pure-button pure-button-primary"  id="search" type="button">Search</button>
            <button class="pure-button pure-button-primary_r"  id="cleare" type="button">Reset</button>
        </div>
        <div align="left" style="padding-top: 6px;font-size:10px;">
            <div id="accordion-container">
                <h2 class="accordion-header">&nbsp;+ Add Search Criteria</h2>
                <div class="accordion-content">

                    <table border="0" width="100%" class="pure-table">
                        <tr style="border-bottom: 1px solid #cbcbcb;">
                            <td width="20%" >
                                <label for="name">Tagging Status </label>
                            </td>
                            <td >
                                <select name="taggingstatus" id="slcttaggingstatus">
                                    <option value="" <?if($am_tagging_status == "")echo "selected";?>>SELECT</option>
                                    <option value="Y" <?if($am_tagging_status == "Y")echo "selected";?>>YES</option>
                                    <option value="N" <?if($am_tagging_status == "N")echo "selected";?>>NO</option>
                                </select>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #cbcbcb;">
                            <td width="20%">
                                <label for="name">Campus Code</label>
                            </td>
                            <td>
                                <select name="campus" id="slctcampus">
                                    <?
                                    $stcampus  = "<option value=\"\">SELECT</option>\n";
                                    for($i=0;$i<count($ccode);$i++) {
                                        $stcampus .= "<option value=\"".$ccode[$i][0]."\" ".selected($ccode[$i][0],$ab_campus_code)." >".$ccode[$i][2]."</option>\n";
                                    }
                                    echo $stcampus;
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #cbcbcb;">
                            <td width="20%" >
                                <label for="name">Area Code</label>
                            </td>
                            <td >
                                <select name="area" id="slctarea">
                                    <?
                                    $starea  = "<option value=\"\">SELECT</option>\n";
                                    for($i=0;$i<count($acode);$i++) {
                                        $starea .= "<option value=\"".$acode[$i][0]."\" ".selected($acode[$i][0],$ab_area_code)." >".$acode[$i][2]."</option>\n";
                                    }
                                    echo $starea;
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #cbcbcb;">
                            <td width="20%" >
                                <label for="name">Building Code</label>
                            </td>
                            <td >
                                <select name="building" id="slctbuilding">
                                    <?
                                    $stbuilding  = "<option value=\"\">SELECT</option>\n";
                                    for($i=0;$i<count($bcode);$i++) {
                                        $stbuilding .= "<option value=\"".$bcode[$i][0]."\" ".selected($bcode[$i][0],$ab_building_code)." >".$bcode[$i][2]."</option>\n";
                                    }
                                    echo $stbuilding;
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #cbcbcb;">
                            <td width="20%" >
                                <label for="name">Level Code</label>
                            </td>
                            <td >
                                <select name="level" id="slctlevel">
                                    <?
                                    $stlevel  = "<option value=\"\">SELECT</option>\n";
                                    for($i=0;$i<count($lcode);$i++) {
                                        $stlevel .= "<option value=\"".$lcode[$i][0]."\" ".selected($lcode[$i][0],$ab_level_code)." >".$lcode[$i][2]."</option>\n";
                                    }
                                    echo $stlevel;
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #cbcbcb;">
                            <td width="20%" >
                                <label for="name">Type Code</label>
                            </td>
                            <td >
                                <select name="type" id="slcttype">
                                    <?
                                    $sttype  = "<option value=\"\">SELECT</option>\n";
                                    for($i=0;$i<count($tcode);$i++) {
                                        $sttype .= "<option value=\"".$tcode[$i][0]."\" ".selected($tcode[$i][0],$ab_type_code)." >".$tcode[$i][2]."</option>\n";
                                    }
                                    echo $sttype;
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #cbcbcb;">
                            <td width="20%" >
                                <label for="name">Location Main</label>
                            </td>
                            <td >
                                <select name="system" id="slctsystem">
                                    <?
                                    $stsystem  = "<option value=\"\">SELECT</option>\n";
                                    for($i=0;$i<count($scode);$i++) {
                                        $stsystem .= "<option value=\"".$scode[$i][0]."\" ".selected($scode[$i][0],$ab_system_code)." >".$scode[$i][2]."</option>\n";
                                    }
                                    echo $stsystem;
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #cbcbcb;">
                            <td width="20%" >
                                <label for="name">Location Detail</label>
                            </td>
                            <td >
                                <select name="other" id="slctother">
                                    <?
                                    $stother  = "<option value=\"\">SELECT</option>\n";
                                    for($i=0;$i<count($ocode);$i++) {
                                        $stother .= "<option value=\"".$ocode[$i][0]."\" ".selected($ocode[$i][0],$ab_other_code)." >".$ocode[$i][2]."</option>\n";
                                    }
                                    echo $stother;
                                    ?>
                                </select>
                            </td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
    </form>

    <div style="padding-bottom: 10px;font-size:12px;">
        <table width="100%">
            <tr>
                <td>
                    <a href="#" onClick=""><img src="include/img/iconoffice/excel.png"></img></a>
                    <a href="#" onClick=""><img src="include/img/iconoffice/pdf.png"></img></a>
                </td>
                <td align="right">
                    <button class="pure-button pure-button-primary" id="back" type="button">Main Page</button>
                    <button class="pure-button pure-button-primary_g" id="view_asset_add" type="button">Add New</button>
                    <button class="pure-button pure-button-primary_r" id="delete_selected" type="button">Delete Selected</button>
                </td>
            </tr>
        </table>
    </div>
    <form id="form2">
        <table class="pure-table" width="100%">
            <thead>
                <tr >
                    <th width="2%"><input name="checkboxx" type="checkbox" id="selecctall" value=""></th>
                    <th width="5%">No</th>
                    <th width="10%">Asset No</th>
                    <th>Description</th>
                    <th width="5%">Tagging Status</th>
                    <th width="5%" colspan="4">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $pages = new Paginator;
                $db = MySQL::getInstance();

                $sql = "SELECT `am_seq_no`,`am_asset_no`,`am_asset_desc`, `am_tagging_status`
                        FROM `asset_main`
                        LEFT JOIN `asset_barcode` ON `am_seq_no` = `ab_main_seqno`
                        LEFT JOIN `campus_main` ON `cm_seq_no` = `ab_campus_code`
                        LEFT JOIN `area_main` ON `arm_seq_no` = `ab_area_code`
                        LEFT JOIN `building_main` ON `bm_seq_no` = `ab_building_code`
                        LEFT JOIN `building_level_main` ON `blm_seq_no` = `ab_level_code`
                        LEFT JOIN `asset_type_code` ON `atc_seq_no` = `ab_type_code`
                        LEFT JOIN `location_main` ON `lm_seq_no` = `ab_type_code`
                        LEFT JOIN `location_main_detail` ON `lmd_seq_no` = `ab_type_code`
                        WHERE `ab_status` = 'A' ";

                if(isset($am_tagging_status) && !empty ($am_tagging_status)) {
                    $sql .=" AND `am_tagging_status` = '".$am_tagging_status."' ";
                }
                if(isset($am_asset_no) && !empty ($asset_no)) {
                    $sql .=" AND `am_asset_no` = ".$am_asset_no." ";
                }
                if(isset($ab_campus_code) && !empty ($ab_campus_code)) {
                    $sql .=" AND `ab_campus_code` = ".$ab_campus_code." ";
                }
                if(isset($ab_area_code) && !empty ($ab_area_code)) {
                    $sql .=" AND `ab_area_code` = ".$ab_area_code." ";
                }
                if(isset($ab_building_code) && !empty ($ab_building_code)) {
                    $sql .=" AND `ab_building_code` = ".$ab_building_code." ";
                }
                if(isset($ab_level_code) && !empty ($ab_level_code)) {
                    $sql .=" AND `ab_level_code` = ".$ab_level_code." ";
                }
                if(isset($ab_type_code) && !empty ($ab_type_code)) {
                    $sql .=" AND `ab_type_code` = ".$ab_type_code." ";
                }
                if(isset($ab_system_code) && !empty ($ab_system_code)) {
                    $sql .=" AND `ab_system_code` = ".$ab_system_code." ";
                }
                if(isset($ab_other_code) && !empty ($ab_other_code)) {
                    $sql .=" AND `ab_other_code` = ".$ab_other_code." ";
                }

                $stmt = $db->prepare($sql);
                $stmt->execute();
                $stmt->store_result();
                $pages->items_total = $stmt->num_rows;
                //$pages->items_total = 200000;
                $pages->mid_range = 7;
                $pages->paginate();

                $y = 1;
                if($stmt->num_rows >0) {
                    $sql .= $pages->limit;
                }

                $stmt2 = $db->prepare($sql);
                $stmt2->execute();
                $stmt2->store_result();
                $stmt2->bind_result($am_seq_no,$am_asset_no,$am_asset_desc,$am_tagging_status);
                if($stmt2->num_rows > 0) {
                    while ($stmt2->fetch()) {
                        if ($y % 2 == 0) {
                            $odd = 'class = "pure-table-odd"';
                        }else {
                            $odd = "";
                        }
                        if($am_tagging_status == "Y") {
                            $tstatus = "YES";
                        }else {
                            $tstatus = "N0";
                        }
                        ?>
                <tr <?php echo $odd;?>>
                    <td><input name="checkbox[]" type="checkbox" class="checkbox1" id="checkbox[]" value="<? echo encode($am_seq_no); ?>"></td>
                    <td><?php echo $y; ?></td>
                    <td><?php echo output($am_asset_no);?></td>
                    <td><?php echo output($am_asset_desc);?></td>
                    <td><?php echo output($tstatus);?></td>
                    
                    <td>
                        <a href="#" onClick="print_barcode('<?php echo encode($am_seq_no);?>'); return false"><img src="include/img/barcode2.png"></img></a>
                    </td>
                    <td>
                        <a href="#" onClick="view_asset_edit('<?php echo encode($am_seq_no)?>','<?php echo $_GET['ipp'];?>','<?php echo $_GET['page'];?>'); return false"><img src="include/img/detail3.png"></img></a>
                    </td>
                    <td>
                        <a href="#" onClick="view_asset_delete('<?php echo encode($am_seq_no)?>','<?php echo $_GET['ipp'];?>','<?php echo $_GET['page'];?>');return false"><img src="include/img/delete2.png"></img></a>
                    </td>
                </tr>
                        <?php $y++;
                    }
                }else {
                    ?>
                <tr>
                    <td colspan="6">No Data</td>
                </tr>
                    <?php
                }
                $stmt->close();
                $stmt2->close();
                $db->close();
                ?>
            </tbody>
        </table>
    </form>
    <div style="padding-top: 20px;font-size:12px; padding-right:10px; ">
        <table border="0" width="100%">
            <tr>
                <td><?php echo $pages->display_pages();?></td>
                <td width="5%" align="right">Page &nbsp;</td>
                <td width="10%"><?php echo $pages->display_jump_menu();?></td>
                <td width="11%" align="right">Show Record &nbsp;</td>
                <td width="10%"><?php echo $pages->display_items_per_page();?></td>
            </tr>
        </table>
    </div>
</div>