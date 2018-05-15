<?php
// application/models/Admin/viewModel.class.php

class viewModel{
    private $data = array();
    private $render = FALSE;
    public function __construct($view = "index"){
        $file = VIEW_PATH."home".DS.$view.".view.php";
        if($view == "index"){
            $file = VIEW_PATH."home".DS."index.html";
        }
        //$this->data = array();
        if(file_exists($file)){
            $this->render = $file;
        }
    }
    
    public function setdata($result){
        
        $this->data += $result;
    }
    
    public function __destruct(){
        $data = $this->data;
        include($this->render);
    }
}


?>