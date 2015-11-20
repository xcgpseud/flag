<?php

require_once "php/factories/OverlayFactory.php";
require_once "php/data/Overlay.php";

class Facade
{

    //Class variables
    private $overlay;

    public function __construct(){
        $this->overlay = OverlayFactory::createOverlay();
    }

    public function checkImage($file){
        return $this->overlay->checkImage($file);
    }

    public function overlayImage($file, $flag){
        return $this->overlay->overlayImage($file, $flag);
    }
}