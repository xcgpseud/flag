<?php

class Overlay
{

    //Class variables
    private $extension, $isImage, $flag, $width, $height;

    private function uploadFile($file){
        //Target directory to store the image temporarily
        $targetDir = "temp/";

        //Target file is the filename where the image will be stored
        $targetFile = $targetDir . basename($file["name"]);

        //Get the image extension
        $this->extension = pathinfo($targetFile, PATHINFO_EXTENSION);
    }

    public function checkImage($file){

        $this->uploadFile($file);

        $check = getimagesize($file["tmp_name"]);

        if($check !== false){
            $this->isImage = true;
        }else{
            $this->isImage = false;
        }

        return $this->isImage;
    }

    public function overlayImage($file, $flag){

        $this->uploadFile($file);

        $image = $file["tmp_name"];
        $this->flag = $flag;

        //Image sizes
        $sizes = getimagesize($image);
        $this->width = $sizes[0];
        $this->height = $sizes[1];

        //Arrange the extension
        $this->extension = strtolower($this->extension);

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

        //Path of the canadian flag image
        $path_canada = "images/canada.png";

        //Create image resource with canada flag
        $canada = imagecreatefrompng($path_canada);

        //Get the sizes of the canada flag image
        $sizes_canada = getimagesize($path_canada);
        $width_canada = $sizes_canada[0];
        $height_canada = $sizes_canada[1];

        //Our current image sizes
        $width = $this->width;
        $height = $this->height;

        //Create a base, empty image to resize the canada flag in to
        $resized_canada = imagecreatetruecolor($width, $height);

        //Resize the canada flag in to our new image resource
        imagecopyresized($resized_canada, $canada, 0, 0, 0, 0, $width, $height, $width_canada, $height_canada);

        //Merge the new canada flag with our uploaded image, with 40% transparency
        imagecopymerge($img, $resized_canada, 0, 0, 0, 0, $width, $height, 40);

        return $img;
    }

    private function overlayGermany($img){

        $width = $this->width;
        $height = $this->height;

        $black = imagecolorallocatealpha($img, 0, 0, 0, 75);
        $red = imagecolorallocatealpha($img, 255, 0, 0, 75);
        $yellow = imagecolorallocatealpha($img, 255, 255, 0, 75);

        $third = $height * .33;
        $middle = $height * .34;

        //First is the top 33%
        $blackStart = 0;
        $blackEnd = $third;

        //Then the middle 34%
        $redStart = $blackEnd;
        $redEnd = $redStart + $middle;

        //Then the last 33%
        $yellowStart = $redEnd;
        $yellowEnd = $yellowStart + $third;

        imagefilledrectangle($img, 0, $blackStart, $width, $blackEnd, $black);
        imagefilledrectangle($img, 0, $redStart, $width, $redEnd, $red);
        imagefilledrectangle($img, 0, $yellowStart, $width, $yellowEnd, $yellow);

        return $img;
    }

    private function overlayScotland($img){

        $width = $this->width;
        $height = $this->height;

        $white = imagecolorallocatealpha($img, 255, 255, 255, 75);
        $blue = imagecolorallocatealpha($img, 0, 0, 255, 75);

        $smallest = min($width, $height);

        //Make the width of the red line 20% of the smallest
        $lineWidth = $smallest * .2;
        $halfLine = $lineWidth / 2;

        $topPolyPointX = $width / 2;
        $topPolyPointY = ($height / 2) - $halfLine;
        $topPolyEndX = $width - $halfLine;

        $bottomPolyPointX = $width / 2;
        $bottomPolyPointY = ($height / 2) + $halfLine;
        $bottomPolyEndX = $width - $halfLine;

        $leftPolyPointX = ($width / 2) - $halfLine;
        $leftPolyPointY = $height / 2;
        $leftPolyEndY = $height - $halfLine;

        $rightPolyPointX = ($width / 2) + $halfLine;
        $rightPolyPointY = $height / 2;
        $rightPolyEndY = $height - $halfLine;

        imagefilledrectangle($img, 0, 0, $width, $height, $white);

        imagefilledpolygon($img, array($halfLine,0, $topPolyPointX,$topPolyPointY, $topPolyEndX,0), 3, $blue);
        imagefilledpolygon($img, array($halfLine,$height, $bottomPolyPointX,$bottomPolyPointY, $bottomPolyEndX,$height), 3, $blue);
        imagefilledpolygon($img, array(0,$halfLine, $leftPolyPointX,$leftPolyPointY, 0,$leftPolyEndY), 3, $blue);
        imagefilledpolygon($img, array($width,$halfLine, $rightPolyPointX,$rightPolyPointY, $width,$rightPolyEndY), 3, $blue);

        return $img;
    }

    private function overlayEngland($img){

        $width = $this->width;
        $height = $this->height;

        $white = imagecolorallocatealpha($img, 255, 255, 255, 75);
        $red = imagecolorallocatealpha($img, 255, 0, 0, 75);

        $smallest = min($width, $height);

        //Make the width of the line 20% of the smallest
        $lineWidth = $smallest * .2;

        $lineX = $width / 2;
        $lineY = $height / 2;

        $xStop = $lineX - ($lineWidth / 2);
        $xStart = $lineX + ($lineWidth / 2);

        imagefilledrectangle($img, 0, 0, $width, $height, $white);

        imagesetthickness($img, $lineWidth);

        imageline($img, $lineX, 0, $lineX, $height, $red);
        imageline($img, 0, $lineY, $xStop, $lineY, $red);
        imageline($img, $xStart, $lineY, $width, $lineY, $red);

        return $img;
    }

    private function overlayJapan($img){

        $width = $this->width;
        $height = $this->height;

        $white = imagecolorallocatealpha($img, 255, 255, 255, 75);
        $red =imagecolorallocatealpha($img, 255, 0, 0, 75);

        //Get the smallest of the width / height to work out the w/h of the circle
        $smallest = min($width, $height);
        $circleWidthHeight = $smallest * .6;

        //Circle X / Y
        $circleX = $width / 2;
        $circleY = $height / 2;

        //Draw the white background
        imagefilledrectangle($img, 0, 0, $width, $height, $white);

        //Draw the red circle
        imagefilledellipse($img, $circleX, $circleY, $circleWidthHeight, $circleWidthHeight, $red);

        return $img;
    }

    private function overlayNetherlands($img){

        $width = $this->width;
        $height = $this->height;

        $blue = imagecolorallocatealpha($img, 0, 0,255, 75);
        $white = imagecolorallocatealpha($img, 255, 255, 255, 75);
        $red =imagecolorallocatealpha($img, 255, 0, 0, 75);

        $third = $height * .33;
        $middle = $height * .34;

        //First is the top 33%
        $redStart = 0;
        $redEnd = $third;

        //Then the middle 34%
        $whiteStart = $redEnd;
        $whiteEnd = $whiteStart + $middle;

        //Then the last 33%
        $blueStart = $whiteEnd;
        $blueEnd = $blueStart + $third;

        imagefilledrectangle($img, 0, $redStart, $width, $redEnd, $red);
        imagefilledrectangle($img, 0, $whiteStart, $width, $whiteEnd, $white);
        imagefilledrectangle($img, 0, $blueStart, $width, $blueEnd, $blue);

        return $img;
    }

    private function overlayFrance($img){

        $width = $this->width;
        $height = $this->height;

        $blue = imagecolorallocatealpha($img, 0, 0,255, 75);
        $white = imagecolorallocatealpha($img, 255, 255, 255, 75);
        $red =imagecolorallocatealpha($img, 255, 0, 0, 75);

        $third = $width * .33;
        $middle = $width * .34;

        //Start is 0% -> 33%
        $blueStart = 0;
        $blueEnd = $third;

        //Middle is 33% -> 67%
        $whiteStart = $third;
        $whiteEnd = $whiteStart + $middle;

        //End is 67% -> 100%
        $redStart = $whiteEnd;
        $redEnd = $redStart + $third;

        imagefilledrectangle($img, $blueStart, 0, $blueEnd, $height, $blue);
        imagefilledrectangle($img, $whiteStart, 0, $whiteEnd, $height, $white);
        imagefilledrectangle($img, $redStart, 0, $redEnd, $height, $red);

        return $img;
    }
}