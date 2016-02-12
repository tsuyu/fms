<?php
require_once '../helper.php';
require_once '../../class.adapter.php';
require_once '../../session.php';
require_once 'database.php';

$session = new session();
$session->start_session('_s', false);

if(isset($_POST['shout'])){
  $shout = mysqli_real_escape_string($connection, $_POST['shout']);
  $date = date("Y-m-d H:i:s");

    
    
    //Query for Database
    $query = "INSERT INTO apps_shoutbox_main (asm_name, asm_message, asm_time) VALUES ('".$_SESSION['username']."','$shout','$date')";
  
    //Check for errors
    if(!mysqli_query($connection, $query)){
      echo "Error: ".mysqli_error($connection);
    
    } else {
      echo '<li><b>'.$_SESSION['username']."</b>: ".$shout.' ['.$date.'] </li>';
    } //End if
    
} //End if


?>
