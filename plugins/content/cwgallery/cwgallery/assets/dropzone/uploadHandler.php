<?php
$ds = DIRECTORY_SEPARATOR;  //1
 
$storeFolder = 'uploads';   //2
 
if (!empty($_FILES)) {
    //$prefix = rand();
    $prefix = '';
    $tempFile = $_FILES['file']['tmp_name'];          //3             
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;  //4     
    $targetFile =  $targetPath. $prefix.$_FILES['file']['name'];  //5
    move_uploaded_file($tempFile,$targetFile); //6
}   
?>  
