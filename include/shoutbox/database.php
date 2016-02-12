<?php
//Connect to MySQL
$connection = mysqli_connect("localhost", "umphatt_user","abc123", "umpholdings_db");


if(mysqli_connect_errno()){
  echo 'Failed to connect: '.mysqli_connect_error();
}


?>
