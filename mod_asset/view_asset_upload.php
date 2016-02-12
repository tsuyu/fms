<?php

$id = decode($_GET['id']);
$page = $_GET['page'];
$ipp = $_GET['ipp'];

if($_POST)
{
    $rollback = FALSE;
    $db = MySQL::getInstance();
    $db->autocommit(FALSE);

    /*if(!isset($_POST['mName']) || strlen($_POST['mName'])<1)
    {
        //required variables are empty
        die("Title is empty!");
    }*/


    
    if($_FILES['mFile']['error'])
    {
        //File upload error encountered
        //die(upload_errors($_FILES['mFile']['error']));
        redirect("home.php?mod=".encode('2')."&app=".encode('view_asset_edit')."&id=".encode($id)."&page=".$page."&ipp=".$ipp,"Failed!");
    }

    $FileName           = strtolower($_FILES['mFile']['name']); //uploaded file name
   // $FileTitle          = mysql_real_escape_string($_POST['mName']); // file title
    $ImageExt           = substr($FileName, strrpos($FileName, '.')); //file extension
    $FileType           = $_FILES['mFile']['type']; //file type
    $FileSize           = $_FILES['mFile']["size"]; //file size
    $RandNumber         = rand(0, 9999999999); //Random number to make each filename unique.
    $uploaded_date      = date("Y-m-d H:i:s");

    if($FileSize > 350000){
        redirect("home.php?mod=".encode('2')."&app=".encode('view_asset_edit')."&id=".encode($id)."&page=".$page."&ipp=".$ipp,
                "Failed! Only images under 350Kb are accepted for upload");
    }

    switch(strtolower($FileType))
    {
        //allowed file types
        case 'image/png': //png file
        case 'image/gif': //gif file
        case 'image/jpeg': //jpeg file
        //case 'application/pdf': //PDF file
        //case 'application/msword': //ms word file
        //case 'application/vnd.ms-excel': //ms excel file
        //case 'application/x-zip-compressed': //zip file
        //case 'text/plain': //text file
        //case 'text/html': //html file
            break;
        default:
           redirect("home.php?mod=".encode('2')."&app=".encode('view_asset_edit')."&id=".encode($id)."&page=".$page."&ipp=".$ipp,"Failed!"); //output error
    }


    //File Title will be used as new File name
    //$NewFileName = preg_replace(array('/s/', '/.[.]+/', '/[^w_.-]/'), array('_', '.', ''), strtolower($FileTitle));
   $NewFileName = zero_pad($id, 4).$RandNumber.$ImageExt;
   //Rename and save uploded file to destination folder.
   
   $new_directory = "uploads/asset/".$id."/";
   //echo $new_directory;
   if(!is_dir($new_directory)) {
      mkdir($new_directory);
   }

   if(move_uploaded_file($_FILES['mFile']["tmp_name"], $new_directory.$NewFileName))
   {
        //connect & insert file record in database
        $sql = "INSERT INTO `asset_photos`(`ap_main_seqno`,`ap_filename`,ap_upload_by,ap_upload_date)
            VALUES(?,?,?,?)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('ssss',$id,$NewFileName,$_SESSION['username'],date('Y-m-d H:i:s'));
        $rc = $stmt->execute();
        if ( false===$rc ) {
            $rollback = TRUE;
        }
        $db->commit();
        $db->close();
        redirect("home.php?mod=".encode('2')."&app=".encode('view_asset_edit')."&id=".encode($id)."&page=".$page."&ipp=".$ipp,"Commit!");
   }else{
        $db->rollback();
        $db->close();
        redirect("home.php?mod=".encode('2')."&app=".encode('view_asset_edit')."&id=".encode($id)."&page=".$page."&ipp=".$ipp,"Failed!");
   }
}

//function outputs upload error messages, http://www.php.net/manual/en/features.file-upload.errors.php#90522
function upload_errors($err_code) {
    switch ($err_code) {
        case UPLOAD_ERR_INI_SIZE:
            return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
        case UPLOAD_ERR_FORM_SIZE:
            return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
        case UPLOAD_ERR_PARTIAL:
            return 'The uploaded file was only partially uploaded';
        case UPLOAD_ERR_NO_FILE:
            return 'No file was uploaded';
        case UPLOAD_ERR_NO_TMP_DIR:
            return 'Missing a temporary folder';
        case UPLOAD_ERR_CANT_WRITE:
            return 'Failed to write file to disk';
        case UPLOAD_ERR_EXTENSION:
            return 'File upload stopped by extension';
        default:
            return 'Unknown upload error';
    }
}
?>