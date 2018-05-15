<?php
//framework/core/Framework.class.php
class Framework{
    public static function run(){
//        echo "run()";
        self::init();//CHUSHIHUA 
        self::autoload();//ZIDONGJIAZAILEI
        self::dispatch();//ZIDONGFENFA
    //do three important things
    }
    //initialization
    private static function init(){
        //Define path constants
        define("DS",DIRECTORY_SEPARATOR);
        define("ROOT",getcwd().DS);
        define("APP_PATH",ROOT.'application'.DS);
        define("FRAMEWORK_PATH",ROOT."framework".DS);
        define("PUBLIC_PATH",ROOT."public".DS);
        
        define("CONFIG_PATH",APP_PATH."config".DS);
        define("CONTROLLER_PATH",APP_PATH."controllers".DS);
        define("MODEL_PATH",APP_PATH."models".DS);
        define("VIEW_PATH",APP_PATH."views".DS);
        
        define("CORE_PATH",FRAMEWORK_PATH."core".DS);
        define("DB_PATH",FRAMEWORK_PATH."database".DS);
        define("LIB_PATH",FRAMEWORK_PATH."libraries".DS);
        define("HELPER_PATH",FRAMEWORK_PATH."helpers".DS);
        define("UPLOAD_PATH",FRAMEWORK_PATH."uploads".DS);
        
        //define platform, controller, action, for example:
        //index.php?p=admin&c=Goods&a=add
        define("PLATFORM",isset($_REQUEST['p'])?$_REQUEST['p']:'home');
        define("CONTROLLER",isset($_REQUEST['c'])?$_REQUEST['c']:'Index');//Index before
        define("ACTION",isset($_REQUEST['a'])?$_REQUEST['a']:'index');
        
        define("CURR_CONTROLLER_PATH",CONTROLLER_PATH.PLATFORM.DS);
        define("CURR_VIEW_PATH",VIEW_PATH.PLATFORM.DS);
        
        //LOAD CORE CLASSES
        require CORE_PATH."Controller.class.php";
        require CORE_PATH."Loader.class.php";
        require DB_PATH."Mysql.class.php";
        require CORE_PATH."Model.class.php";
        
        //load configuration file
        //$GLOBALS['config'] = include CONFIG_PATH."config.php";
        require CONFIG_PATH."config.php";

        //start session
        session_start();
    }
    
    //Autoloading
    private static function autoload(){
        spl_autoload_register(array(__CLASS__,'load'));
        
    }
    //define a custom Load method
    private static function load($classname){
        //Here simply autoload app&tsquo;s controller  and model classes
        if(substr($classname, -10) == "Controller"){
            //Controller
            require_once CURR_CONTROLLER_PATH."$classname.class.php";
            
        }
        elseif(substr($classname,-5) == "Model"){
            //Model
            require_once MODEL_PATH."$classname.class.php";
        }
        
    }
    //对于一个控制器类，它需要被命名成类似xxxController.class.php，对于一个模型类，需要被命名成xxModel.class.php
    
    //Routing and dispatching
    private static function dispatch(){
        //Instantiate the controller class and call its action method
        $controller_name = CONTROLLER."Controller";
        $action_name = ACTION."Action";
        $controller = new $controller_name;
        $controller->$action_name();
    }
    //index.php将会分发请求到对应的Controller::Aciton()方法
}




?>