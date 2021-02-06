<?php

$filename = $_FILES["filetoupload"]["name"];

// Check if file exists before upload
if(file_exists("upload/" . $filename)){
    echo $filename . " is already exists.";
} else {
    move_uploaded_file($_FILES["filetoupload"]["tmp_name"], "upload/" . $filename);
    echo 'File was uploaded successfully!';
} 

?>