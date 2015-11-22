<?php

class FlagStyle{

    public function horizontalThreeLines($img, $width, $height, $topColour, $middleColour, $bottomColour){

        $third = $height * .33;
        $middle = $height * .34;

        //First is the top 33%
        $topStart = 0;
        $topEnd = $third;

        //Then the middle 34%
        $middleStart = $topEnd;
        $middleEnd = $middleStart + $middle;

        //Then the last 33%
        $bottomStart = $middleEnd;
        $bottomEnd = $bottomStart + $third;

        imagefilledrectangle($img, 0, $topStart, $width, $topEnd, $topColour);
        imagefilledrectangle($img, 0, $middleStart, $width, $middleEnd, $middleColour);
        imagefilledrectangle($img, 0, $bottomStart, $width, $bottomEnd, $bottomColour);

        return $img;
    }

    public function verticalThreeLines($img, $width, $height, $leftColour, $middleColour, $rightColour){

        $third = $width * .33;
        $middle = $width * .34;

        //Start is 0% -> 33%
        $leftStart = 0;
        $leftEnd = $third;

        //Middle is 33% -> 67%
        $middleStart = $third;
        $middleEnd = $middleStart + $middle;

        //End is 67% -> 100%
        $rightStart = $middleEnd;
        $rightEnd = $rightStart + $third;

        imagefilledrectangle($img, $leftStart, 0, $leftEnd, $height, $leftColour);
        imagefilledrectangle($img, $middleStart, 0, $middleEnd, $height, $middleColour);
        imagefilledrectangle($img, $rightStart, 0, $rightEnd, $height, $rightColour);

        return $img;
    }

    public function circleCenter($img, $width, $height, $outerColour, $innerColour){

        //Get the smallest of the width / height to work out the w/h of the circle
        $smallest = min($width, $height);
        $circleWidthHeight = $smallest * .6;

        //Circle X / Y
        $circleX = $width / 2;
        $circleY = $height / 2;

        //Draw the white background
        imagefilledrectangle($img, 0, 0, $width, $height, $outerColour);

        //Draw the red circle
        imagefilledellipse($img, $circleX, $circleY, $circleWidthHeight, $circleWidthHeight, $innerColour);

        return $img;
    }

    public function diagonalCross($img, $width, $height, $backColour, $crossColour){

        $smallest = min($width, $height);

        //Make the width of the lines 20% of the smallest
        $lineWidth = $smallest * .2;
        $halfLine = $lineWidth / 2;

        //Draw the polygons in the background colour instead of drawing the lines, as when the lines overlap, the opacity changes in the overlap space
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


        imagefilledrectangle($img, 0, 0, $width, $height, $crossColour);

        imagefilledpolygon($img, array($halfLine,0, $topPolyPointX,$topPolyPointY, $topPolyEndX,0), 3, $backColour);
        imagefilledpolygon($img, array($halfLine,$height, $bottomPolyPointX,$bottomPolyPointY, $bottomPolyEndX,$height), 3, $backColour);
        imagefilledpolygon($img, array(0,$halfLine, $leftPolyPointX,$leftPolyPointY, 0,$leftPolyEndY), 3, $backColour);
        imagefilledpolygon($img, array($width,$halfLine, $rightPolyPointX,$rightPolyPointY, $width,$rightPolyEndY), 3, $backColour);

        return $img;
    }

    public function straightCross($img, $width, $height, $backColour, $crossColour){

        $smallest = min($width, $height);

        //Make the width of the line 20% of the smallest
        $lineWidth = ceil($smallest * .2);

        $lineX = $width / 2;
        $lineY = $height / 2;

        $xStop = ($lineX - ($lineWidth / 2)) -1;
        $xStart = $lineX + ($lineWidth / 2);

        imagefilledrectangle($img, 0, 0, $width, $height, $backColour);

        imagesetthickness($img, $lineWidth);

        imageline($img, $lineX, 0, $lineX, $height, $crossColour);
        imageline($img, 0, $lineY, $xStop, $lineY, $crossColour);
        imageline($img, $xStart, $lineY, $width, $lineY, $crossColour);

        return $img;
    }

    public function imageOverlay($img, $width, $height, $overlayImage){

        //Create image resource with canada flag
        $topImage = imagecreatefrompng($overlayImage);

        //Get the sizes of the canada flag image
        $sizesTopImage = getimagesize($overlayImage);

        $widthTopImage = $sizesTopImage[0];
        $heightTopImage = $sizesTopImage[1];

        //Create a base, empty image to resize the canada flag in to
        $resizedTopImage = imagecreatetruecolor($width, $height);

        //Resize the canada flag in to our new image resource
        imagecopyresized($resizedTopImage, $topImage, 0, 0, 0, 0, $width, $height, $widthTopImage, $heightTopImage);

        //Merge the new canada flag with our uploaded image, with 40% transparency
        imagecopymerge($img, $resizedTopImage, 0, 0, 0, 0, $width, $height, 40);

        return $img;
    }
}