<?php

class FileManagement{

    private $extension;

    public function uploadFile($file){

        //Target directory to store the image temporarily
        $targetDir = "temp/";

        //Target file is the filename where the image will be stored
        $targetFile = $targetDir . basename($file["name"]);

        //Get the image extension
        $this->extension = pathinfo($targetFile, PATHINFO_EXTENSION);

        //Return the extension
        return $this->extension;
    }

    public function checkIsImage($file){

        //Upload the file
        $this->uploadFile($file);

        //Get the image sizes (will return false if is not an image)
        $check = getimagesize($file["tmp_name"]);

        //If it did not return false
        if($check !== false){
            //Then it IS an image
            $this->isImage = true;
        }else{
            //Else it is not
            $this->isImage = false;
        }

        //Return the boolean result
        return $this->isImage;
    }
}