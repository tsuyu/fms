<?php
$id = decode($_GET['id']);
$db = MySQL::getInstance();
$stmt = $db->prepare("SELECT `am_seq_no`, `am_asset_no`,`am_asset_desc`,`am_tagging_status`
    FROM `asset_main` WHERE `am_seq_no` = ? LIMIT 1");
$stmt->bind_param("s", $id);
$stmt->execute();
$stmt->bind_result($am_seq_no,$am_asset_no,$am_asset_desc,$am_tagging_status);
$stmt->fetch();
$stmt->close();

$stmt2 = $db->prepare("SELECT `ab_campus_code`, `ab_area_code`,`ab_building_code`,`ab_level_code`,
    `ab_type_code`,`ab_system_code`,`ab_other_code`,`ab_seq_no` FROM `asset_barcode`
    WHERE `ab_main_seqno` = ? AND `ab_status` = 'A' LIMIT 1");
$stmt2->bind_param("s", $id);
$stmt2->execute();
$stmt2->bind_result($ab_campus_code, $ab_area_code,$ab_building_code,$ab_level_code,
        $ab_type_code,$ab_system_code,$ab_other_code,$ab_seq_no);
$stmt2->fetch();
$stmt2->close();

//$barcode = array($ab_campus_code);
$ccode = bcode('campus_main',MySQL::getInstance(),'cm_seq_no','cm_campus_code','cm_campus_desc');
$acode = bcode('area_main',MySQL::getInstance(),'arm_seq_no','arm_area_code','arm_area_desc');
$bcode = bcode('building_main',MySQL::getInstance(),'bm_seq_no','bm_building_code','bm_building_desc');
$lcode = bcode('building_level_main',MySQL::getInstance(),'blm_seq_no','blm_level_code','blm_level_desc');
$tcode = bcode('asset_type_code',MySQL::getInstance(),'atc_seq_no','atc_type_code','atc_type_desc');
$scode = bcode('location_main',MySQL::getInstance(),'lm_seq_no','lm_code','lm_name');
$ocode = bcode('location_main_detail',MySQL::getInstance(),'lmd_seq_no','lmd_code','lmd_name');
//echo "<pre>";
//print_r($ccode);
//echo "</pre>";
?>

        <ul class="form-style-1">
       
        <div class="grid">
        <div class="grid__row grid__row--md">
        <div class="grid__item">
                Picture
        </div>
        </div>
            <div class="grid__row grid__row--md">
            <div class="grid__item">
                <li>
                    <?
                    $stmt3 = $db->prepare("SELECT `ap_seq_no`,`ap_filename` FROM `asset_photos` WHERE `ap_main_seqno` = ? ");
                    $stmt3->bind_param("s", $id);
                    $stmt3->execute();
                    $stmt3->bind_result($fileid,$filename);
                    while ($stmt3->fetch()) {
                        echo "<a class=\"example-image-link\" href=\"uploads/asset/".$id."/$filename\" data-lightbox=\"example-set\" data-title=\"\">\n
                    <img class=\"example-image\" src=\"uploads/asset/".$id."/$filename\" width=\"150\" height=\"100\" alt=\"\" /></a>
                        <a href=\"#\" onClick=\"photo_delete('".encode($id)."','".encode($fileid)."','".encode($filename)."','".$_GET['page']."','".$_GET['ipp']."');return false\"><img src=\"include/img/delete.png\"></img></a>";
                    }
                    $stmt3->close();
                    $db->close();
                    ?>
                    
                </li>
            </div></div>
                <div class="grid__row grid__row--md">
              <div class="grid__item">
                <form name="formUploader" id="FileUploader" action="home.php?mod=s2&app=<?php echo encode("view_asset_upload"); ?>&id=<?php echo encode($id); ?>&page=<?php echo $_GET['page']; ?>&ipp=<?php echo $_GET['ipp']; ?>" method="post" enctype="multipart/form-data">
                <input type="file" name="mFile" id="mFile" />
                <button type="submit" name="btn-upload" class="pure-button pure-button-primary">Upload</button>
                </form>
              </div></div>
        </div>
        </ul>
<form id="form1"  method="post" action="home.php?mod=s2&app=<?php echo encode("view_asset_edit_save"); ?>&page=<?php echo $_GET['page']; ?>&ipp=<?php echo $_GET['ipp']; ?>">
            <ul class="form-style-1">
                <input type="hidden" id="txtseqno" name="seq_no" value="<?php echo encode($am_seq_no); ?>"/>
                <input type="hidden" id="txtbarno" name="bar_no" value="<?php echo encode($ab_seq_no); ?>"/>
                <input type="hidden" id="txtpage" name="page" value="<?php echo $_GET['page']; ?>"/>
                <input type="hidden" id="txtipp" name="ipp" value="<?php echo $_GET['ipp']; ?>"/>
                 <div class="grid">
                      <div class="grid__row grid__row--md">
                            <div class="grid__item">
               
                    <input type="checkbox" name="recordstatus" value="A"/> Generate New Code
               </div>
                      </div>
                 <div class="grid__row grid__row--md">
                            <div class="grid__item">
                    <label for="name">Asset No<span class="required">*</span></label>
                    <input type="text" id="txtassetno" name="assetno"  maxlength="19" value="<?php echo $am_asset_no; ?>" class="field-divided"/>

                </div>
                      </div>
                <div class="grid__row grid__row--md">
                            <div class="grid__item">
                    <label for="name">Description<span class="required">*</span></label>
                    <input type="text" id="txtdescription" name="description" value="<?php echo $am_asset_desc; ?>" class="field-long"/>
                </div>
                      </div>
             <div class="grid__row grid__row--md">
                            <div class="grid__item">
                    <label for="name">Tagging Status<span class="required">*</span></label>
                    <select name="taggingstatus" id="slcttaggingstatus">
                        <option value="" <?if($am_tagging_status == "")echo "selected";?>>SELECT</option>
                        <option value="Y" <?if($am_tagging_status == "Y")echo "selected";?>>YES</option>
                        <option value="N" <?if($am_tagging_status == "N")echo "selected";?>>NO</option>
                    </select>
                </div>
                            <div class="grid__item">
                    <label for="name">Campus</label>
                    <select name="campus" id="slctcampus">
                        <?
                        $stcampus  = "<option value=\"\">SELECT</option>\n";
                        for($i=0;$i<count($ccode);$i++) {
                            $stcampus .= "<option value=\"".$ccode[$i][0]."\" ".selected($ccode[$i][0],$ab_campus_code)." >".$ccode[$i][2]."</option>\n";
                        }
                        echo $stcampus;
                        ?>
                    </select>
                            </div>
                <div class="grid__item">
                    <label for="name">Area</label>
                    <select name="area" id="slctarea">
                        <?
                        $starea  = "<option value=\"\">SELECT</option>\n";
                        for($i=0;$i<count($acode);$i++) {
                            $starea .= "<option value=\"".$acode[$i][0]."\" ".selected($acode[$i][0],$ab_area_code)." >".$acode[$i][2]."</option>\n";
                        }
                        echo $starea;
                        ?>
                    </select>
                </div>
                </div>
                        

                  <div class="grid__row grid__row--md">
                            <div class="grid__item">
                
                    <label for="name">Building</label>
                    <select name="building" id="slctbuilding">
                        <?
                        $stbuilding  = "<option value=\"\">SELECT</option>\n";
                        for($i=0;$i<count($bcode);$i++) {
                            $stbuilding .= "<option value=\"".$bcode[$i][0]."\" ".selected($bcode[$i][0],$ab_building_code)." >".$bcode[$i][2]."</option>\n";
                        }
                        echo $stbuilding;
                        ?>
                    </select>
                
                            </div>
                     <div class="grid__item">
                    <label for="name">Level</label>
                    <select name="level" id="slctlevel">
                        <?
                        $stlevel  = "<option value=\"\">SELECT</option>\n";
                        for($i=0;$i<count($lcode);$i++) {
                            $stlevel .= "<option value=\"".$lcode[$i][0]."\" ".selected($lcode[$i][0],$ab_level_code)." >".$lcode[$i][2]."</option>\n";
                        }
                        echo $stlevel;
                        ?>
                    </select>
                </div>
                   <div class="grid__item">
              
                    <label for="name">Type</label>
                    <select name="type" id="slcttype">
                        <?
                        $sttype  = "<option value=\"\">SELECT</option>\n";
                        for($i=0;$i<count($tcode);$i++) {
                            $sttype .= "<option value=\"".$tcode[$i][0]."\" ".selected($tcode[$i][0],$ab_type_code)." >".$tcode[$i][2]."</option>\n";
                        }
                        echo $sttype;
                        ?>
                    </select>
                   </div>
                      </div>
                 <div class="grid__row grid__row--md">
                            <div class="grid__item">
                    <label for="name">System</label>
                    <select name="system" id="slctsystem">
                        <?
                        $stsystem  = "<option value=\"\">SELECT</option>\n";
                        for($i=0;$i<count($scode);$i++) {
                            $stsystem .= "<option value=\"".$scode[$i][0]."\" ".selected($scode[$i][0],$ab_system_code)." >".$scode[$i][2]."</option>\n";
                        }
                        echo $stsystem;
                        ?>
                    </select>
                </div>
                <div class="grid__item">
                    <label for="name">Other</label>
                    <select name="other" id="slctother">
                        <?
                        $stother  = "<option value=\"\">SELECT</option>\n";
                        for($i=0;$i<count($ocode);$i++) {
                            $stother .= "<option value=\"".$ocode[$i][0]."\" ".selected($ocode[$i][0],$ab_other_code)." >".$ocode[$i][2]."</option>\n";
                        }
                        echo $stother;
                        ?>
                    </select>
                </div>
                     <div class="grid__item"></div>
                </div>
                      </div>
                <li>
                    <button class="pure-button pure-button-primary" type="submit" id="btnsubmit">Edit</button>
                    <button class="pure-button pure-button-primary_r" type="button" id="btnclose">Back</button>
                </li>
            </ul>
        </form>

        <script type="text/javascript" src="include/js/lightbox/js/lightbox-plus-jquery.min.js"></script>
        <script type="text/javascript" language="javascript">

            function photo_delete(id,fid,fname,ipp,page){
                if (confirm("Are you sure you wish to delete this photo?"))
                location.href='home.php?mod=s2&app=o4m554o4d584m4s4b42644u4k4f4f4f59414b454t5i526l5&id='+id+"&fid="+fid+"&fname="+fname+"&page="+page+"&ipp="+ipp;
            }

            $(document).ready(function(){

                lightbox.option({
                    'resizeDuration': 200,
                    'wrapAround': true,
                    'maxWidth':400,
                    'maxHeight':400
                });

                $('#btnsubmit').click(function(event) {

                    var error_msg  = [];

                    /*$('#txtassetno').validator({
                        fieldLabel : '- Asset No',
                        invalidEmpty: true,
                        noSpaceFirstLast: true,
                        error: function(stat,type,msg) {
                            error_msg.push(msg.message);
                        }
                    });*/

                    $('#txtdescription').validator({
                        fieldLabel : '- Asset Description',
                        invalidEmpty: true,
                        noSpaceFirstLast: true,
                        error: function(stat,type,msg) {
                            error_msg.push(msg.message);
                        }
                    });

                    $('#slcttaggingstatus').validator({
                        fieldLabel : '- Tagging Status',
                        selected: true,
                        error: function(stat,type,msg) {
                            error_msg.push(msg.message);
                        }
                    });

                    // $('#txtassetno').validator('validate');
                    $('#txtdescription').validator('validate');
                    $('#slcttaggingstatus').validator('validate');

                    var len = error_msg.length;
                    //error_msg.reverse();

                    if(error_msg.length != 0){
                        for(var i=0; i<len; i++){
                            //$('<li>'+error_msg[i]+'</li>').prependTo('#error');
                            error_msg[i];
                        }
                        alert(error_msg.join("\n"));
                        //alert(error_msg);
                        event.preventDefault();
                        return false;
                    }else{
                        //$('#n_error').hide();
                       /// $("#form1").attr('action','home.php?mod=s2&app=o4m554o4d584m4s4b42644e484c4k4d5o434t454&page='+ $("#txtpage").val()+'&ipp='+ $("#txtipp").val());
                        //$("#form1").attr('method','post');
                       // $("#form1").submit();
                        return true;
                    }
                });

                $("#btnprint").click( function(){
                });

                $("#btnclose").click( function(){
                    location.href = "home.php?mod=s2&app=o4m554o4d584m4s4b42644g4m4c444&page="+ $("#txtpage").val()+"&ipp="+ $("#txtipp").val();
                });

               });
        </script>
   