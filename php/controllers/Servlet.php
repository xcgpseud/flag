<?php

require_once "php/core/Facade.php";

class Servlet
{
    private $facade, $isImage;

    public function __construct(){

        $this->facade = new Facade();

        //Definition to prove that we are coming from the servlet; pages will not work otherwise
        define('SERVLET', 1);
    }

    public function processRequest(){

        //Defaults
        $nextPage = "";
        $action = "home";
        $redirect = true;

        if(isset($_POST['action'])){
            $action = $_POST['action'];
        }elseif(isset($_GET['action'])){
            $action = $_GET['action'];
        }

        switch($action){
            case "home":
                $nextPage = $this->home();
                break;
            case "overlay":
                $nextPage = $this->overlay();
                break;
        }

        if($redirect)
            require_once('./web/' . $nextPage);
    }

    private function home(){
        $nextPage = "home.php";
        return $nextPage;
    }

    private function overlay(){

        //Default nextPage is current page
        //This will change assuming everything is okay
        $nextPage = "home.php";

        if(isset($_POST['flag']))
            $flag = $_POST['flag'];

        //If a FILE is sent through
        if(!empty($_FILES["image"]["name"])){

            //We set the next page as img.php, the page we want to display
            $nextPage = "img.php";

            //Grab the file in to an easy variable
            $file = $_FILES["image"];

            //Pass the file to our Overlay page to check that it is an image
            $this->isImage = $this->facade->checkImage($file);

            if($this->isImage == true){
                $this->image = $this->facade->overlayImage($file, $flag);
                if($this->image == false){
                    $nextPage = "home.php";
                }
            }else{
                $nextPage = "home.php";
            }
        }else{
            return $nextPage;
        }

        return $nextPage;
    }
}