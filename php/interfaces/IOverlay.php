<?php

interface IOverlay{
    public function overlayImage($file, $flag);
    public function overlayCanada($img);
    public function overlayGermany($img);
    public function overlayScotland($img);
    public function overlayEngland($img);
    public function overlayJapan($img);
    public function overlayNetherlands($img);
    public function overlayFrance($img);
}