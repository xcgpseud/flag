<?php

require_once "php/factories/OverlayFactory.php";
require_once "php/factories/FileManagementFactory.php";
require_once "php/data/Overlay.php";
require_once "php/data/FileManagement.php";

class Facade
{

    //Class variables
    private $overlay, $fileManagement;

    public function __construct(){
        $this->overlay = OverlayFactory::createOverlay();
        $this->fileManagement = FileManagementFactory::createFileManagement();
    }

    public function checkIsImage($file){
        return $this->fileManagement->checkIsImage($file);
    }

    public function overlayImage($file, $flag){
        return $this->overlay->overlayImage($file, $flag);
    }
}