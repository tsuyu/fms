<?php
$ccode = bcode('campus_main',MySQL::getInstance(),'cm_seq_no','cm_campus_code','cm_campus_desc');
$acode = bcode('area_main',MySQL::getInstance(),'arm_seq_no','arm_area_code','arm_area_desc');
$bcode = bcode('building_main',MySQL::getInstance(),'bm_seq_no','bm_building_code','bm_building_desc');
$lcode = bcode('building_level_main',MySQL::getInstance(),'blm_seq_no','blm_level_code','blm_level_desc');
$tcode = bcode('asset_type_code',MySQL::getInstance(),'atc_seq_no','atc_type_code','atc_type_desc');
$scode = bcode('location_main',MySQL::getInstance(),'lm_seq_no','lm_code','lm_name');
$ocode = bcode('location_main_detail',MySQL::getInstance(),'lmd_seq_no','lmd_code','lmd_name');
?>
<script type="text/javascript" language="javascript">
    $(document).ready(function(){

        $('#btnsubmit').click(function(event) {

            var error_msg  = [];

            /* $('#txtassetno').validator({
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

            //$('#txtassetno').validator('validate');
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
                $("#form1").attr('action','home.php?mod=s2&app=o4m554o4d584m4s4b42644a48474z3x564o4c4');
                $("#form1").attr('method','post');
                $("#form1").submit();

                return true;
            }
        });

        $("#btnprint").click( function(){
        });

        $("#btnclose").click( function(){
            location.href = "home.php?mod=s2&app=o4m554o4d584m4s4b42644g4m4c444";
        });

    });
</script>

<h2 id="p_title" style="padding-bottom: 10px;padding-left: 20px;">Add New Asset</h2>

<form id="form1" action="">
    <ul class="form-style-1">
        <input type="hidden" id="txtseqno" name="seq_no" value="<?php echo encode($am_seq_no); ?>"/>
        <div class="grid">

            <div class="grid__row grid__row--md">
                <div class="grid__item">

                    <input type="checkbox" name="recordstatus" value="A"/> Generate New Code
                </div>
            </div><div class="grid__row grid__row--md">
                <div class="grid__item">
                    <label for="name">Asset No</label>
                    <input type="text" id="txtassetno" name="assetno" size="19" maxlength="19" value="" class="field-divided"/>
                </div>
            </div><div class="grid__row grid__row--md">
                <div class="grid__item">
                    <label for="name">Description<span class="required">*</span></label>
                    <input type="text" id="txtdescription" name="description" value="" class="field-long"/>
                </div>
            </div><div class="grid__row grid__row--md">
                <div class="grid__item">
                    <label for="name">Tagging Status<span class="required">*</span></label>

                    <select name="taggingstatus" id="slcttaggingstatus">
                        <option value="">SELECT</option>
                        <option value="Y">YES</option>
                        <option value="N">NO</option>
                    </select>

                </div>
                <div class="grid__item">
                    <label for="name">Campus</label>

                    <select name="campus" id="slctcampus">
                        <?
                        $stcampus  = "<option value=\"\">SELECT</option>\n";
                        for($i=0;$i<count($ccode);$i++) {
                            $stcampus .= "<option value=\"".$ccode[$i][0]."\">".$ccode[$i][2]."</option>\n";
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
                            $starea .= "<option value=\"".$acode[$i][0]."\">".$acode[$i][2]."</option>\n";
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
                            $stbuilding .= "<option value=\"".$bcode[$i][0]."\">".$bcode[$i][2]."</option>\n";
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
                            $stlevel .= "<option value=\"".$lcode[$i][0]."\">".$lcode[$i][2]."</option>\n";
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
                            $sttype .= "<option value=\"".$tcode[$i][0]."\">".$tcode[$i][2]."</option>\n";
                        }
                        echo $sttype;
                        ?>
                    </select>
                </div>
            </div>



            <div class="grid__row grid__row--md">
                <div class="grid__item">
                    <label for="name">Location Main</label>

                    <select name="system" id="slctsystem">
                        <?
                        $stsystem  = "<option value=\"\">SELECT</option>\n";
                        for($i=0;$i<count($scode);$i++) {
                            $stsystem .= "<option value=\"".$scode[$i][0]."\">".$scode[$i][2]."</option>\n";
                        }
                        echo $stsystem;
                        ?>
                    </select>
                </div>
                <div class="grid__item">
                    <label for="name">Location Detail</label>

                    <select name="other" id="slctother">
                        <?
                        $stother  = "<option value=\"\">SELECT</option>\n";
                        for($i=0;$i<count($ocode);$i++) {
                            $stother .= "<option value=\"".$ocode[$i][0]."\">".$ocode[$i][2]."</option>\n";
                        }
                        echo $stother;
                        ?>
                    </select>
                </div>
                <div class="grid__item"></div>
            </div>
        </div>

        <?php
        $new = "Add";
        if($_GET['new'] == 1) {
            $new = "Add Another Record";
        }
        ?>
        <li>
            <button class="pure-button pure-button-primary" type="submit" id="btnsubmit"><?php echo $new;?></button>
            <button  onclick="return close();" class="pure-button pure-button-primary_r" type="button" id="btnclose">Back</button>
        </li>
    </ul>
</form>