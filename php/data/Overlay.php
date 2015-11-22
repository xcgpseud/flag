<?php

require_once 'php/data/FileManagement.php';
require_once 'php/data/FlagStyle.php';
require_once 'php/data/FlagColour.php';

class Overlay
{
    //Class variables
    private $extension, $flag, $width, $height, $fileManagement, $flagStyle, $flagColour;

    public function __construct(){

        $this->fileManagement = new FileManagement();
        $this->flagStyle = new FlagStyle();
        $this->flagColour = new FlagColour();
    }

    public function overlayImage($file, $flag){

        ///Get the extension from the uploadFile method
        $this->extension = strtolower($this->fileManagement->uploadFile($file));

        $image = $file["tmp_name"];
        $this->flag = $flag;

        //Image sizes
        $sizes = getimagesize($image);
        $this->width = $sizes[0];
        $this->height = $sizes[1];

        switch($this->extension){
            case "jpg":
                $img = imagecreatefromjpeg($image);
                break;
            case "jpeg":
                $img = imagecreatefromjpeg($image);
                break;
            case "png":
                $img = imagecreatefrompng($image);
                break;
            case "gif":
                $img = imagecreatefromgif($image);
                break;
            default:
                $img = false;
                break;
        }

        switch($this->flag){
            case "france":
                $img = $this->overlayFrance($img);
                break;
            case "netherlands":
                $img = $this->overlayNetherlands($img);
                break;
            case "japan":
                $img = $this->overlayJapan($img);
                break;
            case "england":
                $img = $this->overlayEngland($img);
                break;
            case "scotland":
                $img = $this->overlayScotland($img);
                break;
            case "germany":
                $img = $this->overlayGermany($img);
                break;
            case "canada":
                $img = $this->overlayCanada($img);
                break;
        }

        return $img;
    }

    private function overlayCanada($img){

        /**
         * Overlay the Canadian flag (as an image) on to the uploaded image
         */

        $overlayImage = "images/canada.png";

        $img = $this->flagStyle->imageOverlay($img, $this->width, $this->height, $overlayImage);

        return $img;
    }

    private function overlayGermany($img){

        $colours = $this->flagColour->loadColours($img);

        $top = $colours['black'];
        $middle = $colours['red'];
        $bottom = $colours['yellow'];

        $img = $this->flagStyle->horizontalThreeLines($img, $this->width, $this->height, $top, $middle, $bottom);

        return $img;
    }

    private function overlayScotland($img){

        $colours = $this->flagColour->loadColours($img);

        $background = $colours['blue'];
        $cross = $colours['white'];

        $img = $this->flagStyle->diagonalCross($img, $this->width, $this->height, $background, $cross);

        return $img;
    }

    private function overlayEngland($img){

        $colours = $this->flagColour->loadColours($img);

        $background = $colours['white'];
        $cross = $colours['red'];

        $img = $this->flagStyle->straightCross($img, $this->width, $this->height, $background, $cross);

        return $img;
    }

    private function overlayJapan($img){

        $colours = $this->flagColour->loadColours($img);

        $outer = $colours['white'];
        $inner = $colours['red'];

        $img = $this->flagStyle->circleCenter($img, $this->width, $this->height, $outer, $inner);

        return $img;
    }

    private function overlayNetherlands($img){

        $colours = $this->flagColour->loadColours($img);

        $top = $colours['red'];
        $middle = $colours['white'];
        $bottom = $colours['blue'];

        $img = $this->flagStyle->horizontalThreeLines($img, $this->width, $this->height, $top, $middle, $bottom);

        return $img;
    }

    private function overlayFrance($img){

        $colours = $this->flagColour->loadColours($img);

        $left = $colours['blue'];
        $middle = $colours['white'];
        $right = $colours['red'];

        $img = $this->flagStyle->verticalThreeLines($img, $this->width, $this->height, $left, $middle, $right);

        return $img;
    }
}