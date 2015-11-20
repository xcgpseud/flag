<?php
//Debug line
//echo $this->image; die();

header("Content-type: image/png");

imagepng($this->image);

imagedestroy($this->image);