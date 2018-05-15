<?php
//Base Controller
class BaseController{
    //Base Controller has a property called $loader,it is an instance of Loader class(introduce later)
    protected $loader;
    
    public function __construct(){
        $this->loader = new Loader();
    }
    
    public function redirect($url,$message,$wait = 0){
        if ($wait == 0){
            header("Location:$url");
        }else {
            include CURR_VIEW_PATH."message.html";
        }
        
        exit;
    }
}


?>