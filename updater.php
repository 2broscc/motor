<?php

require_once("system/maxupload.class.php"); 

    $myUpload = new maxUpload(); 
    //$myUpload->setUploadLocation(getcwd().DIRECTORY_SEPARATOR);
    $myUpload->uploadFile();
?>
