
<?php

//echo $_SESSION['89'];

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function taburl(){return $taburl ="?mod=f4e594f4&app=m4e524k4&tabIndex=";}
require_once 'include/tabs.php';
tabs_header(); ?>
<div style="width:100%;">
<?php tabs_start(); ?>
<?php tab( "Location" ); ?>
<script type="text/javascript">

function opennewsletter(){
	emailwindow=dhtmlmodal.open('EmailBox', 'iframe', 'mod_asset/edit_asset.php', 'Edit Asset', 'width=550px,height=400px,center=1,resize=0,scrolling=1')

        emailwindow.onclose=function(){ //Define custom code to run when window is closed
	var theform=this.contentDoc.forms[0] //Access first form inside iframe just for your apperence
	var theemail=this.contentDoc.getElementById("emailfield") //Access form field with id="emailfield" inside iframe
	if (theemail.value.indexOf("@")==-1){ //crude check for invalid email
		alert("Please enter a valid email address")
		return false //cancel closing of modal window
	}
	else{ //else if this is a valid email
		document.getElementById("youremail").innerHTML=theemail.value //Assign the email to a span on the page
		return true //allow closing of window
	}
}
} //End "opennewsletter" function

function deleteUser()
{
    return confirm("Are you sure you wish to delete this entry?");
}
</script>
<?php

$db = Db::getInstance();

$query = "SELECT `AIH_ASSET_NO` FROM `asset_inv_head`";

if ($db->query($query)) {
   while ($row = $db->fetchAssoc()) {
   echo $row['aih_asset_no'];
    }
}

$db->freeResult();

?>
<div class="table-container">
 <table class="pure-table" width="100%">
     <thead>
    <tr >
        <th>No</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Telepon</th>
        <th width="10%">Action</th>
    </tr>
    </thead>
        <tbody>
<?php
$y = 1;

for ($x = 1; $x <= 20; $x++) {

    if ($y % 2 == 0) {
       $odd = "class =".'"pure-table-odd"';
    }else{
       $odd = "";
    }
     ?>
        <tr <?php echo $odd;?>>
            <td><?php echo $y; ?></td>
            <td>Data Anda</td>
            <td>Data Anda</td>
            <td>Data Anda</td>
            <td>
                <center>
                    <a href="#"><img src="include/img/detail.png"></img></a>
                    <a href="#" onClick="opennewsletter(); return false"><img src="include/img/edit.png"></img></a>
                    <a href="#" onClick="return deleteUser();"><img src="include/img/delete.png"></img></a>
                </center>
            </td>
        </tr>
    <?php $y++; } ?>
        </tbody>
  </table>
</div>
<?php tab( "Position" ); ?>
<?php tab( "Item Type" ); ?>
<?php tabs_end(); ?>
</div>