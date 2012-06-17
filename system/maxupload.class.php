<?php
/*************************************************
 * Max's File Uploader
 *
 * Version: 1.0
 * Date: 2007-11-26
 *
 ****************************************************/
class maxUpload{
    var $uploadLocation;
    
    /**
     * Constructor to initialize class varaibles
     * The uploadLocation will be set to the actual 
     * working directory
     *
     * @return maxUpload
     */
    function maxUpload(){
        $this->uploadLocation = getcwd().DIRECTORY_SEPARATOR;
    }

    /**
     * This function sets the directory where to upload the file
     * In case of Windows server use the form: c:\\temp\\
     * In case of Unix server use the form: /tmp/
     *
     * @param String Directory where to store the files
     */
    function setUploadLocation($dir){
        $this->uploadLocation = $dir;
    }
    
    function showUploadForm($msg='',$error=''){
?>
       <div id="container">
            <div id="header"><div id="header_left"></div>
            <div id="header_main">Max's File Uploader</div><div id="header_right"></div></div>
            <div id="content">
<?php
if ($msg != ''){
    echo '<p class="msg">'.$msg.'</p>';
} else if ($error != ''){
    echo '<p class="emsg">'.$error.'</p>';

}
?>
                <form action="" method="post" enctype="multipart/form-data" >
                     <center>
                         <label>File:
                             <input name="myfile" type="file" size="30" />
                         </label>
                         <label>
                             <input type="submit" name="submitBtn" class="sbtn" value="Upload" />
                         </label>
                     </center>
                 </form>
             </div>
             <div id="footer"><a href="http://www.phpf1.com" target="_blank">Powered by PHP F1</a></div>
         </div>
<?php
    }

    function uploadFile(){
        if (!isset($_POST['submitBtn'])){
            $this->showUploadForm();
        } else {
            $msg = '';
            $error = '';
            
            //Check destination directory
            if (!file_exists($this->uploadLocation)){
                $error = "The target directory doesn't exists!";
            } else if (!is_writeable($this->uploadLocation)) {
                $error = "The target directory is not writeable!";
            } else {
                $target_path = $this->uploadLocation . basename( $_FILES['myfile']['name']);

                if(@move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)) {
                    $msg = basename( $_FILES['myfile']['name']).
                    " was uploaded successfully!";
                } else{
                    $error = "The upload process failed!";
                }
            }

            $this->showUploadForm($msg,$error);
        }

    }

}
?>