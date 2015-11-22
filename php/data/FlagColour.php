<?php

class FlagColour{

    private $colours;

    public function loadColours($img){

        $this->colours = array(
            'blue' => imagecolorallocatealpha($img, 0, 0,255, 75),
            'white' => imagecolorallocatealpha($img, 255, 255, 255, 75),
            'red' => imagecolorallocatealpha($img, 255, 0, 0, 75),
            'black' => imagecolorallocatealpha($img, 0, 0, 0, 75),
            'yellow' => imagecolorallocatealpha($img, 255, 255, 0, 75),
        );

        return $this->colours;
    }
}