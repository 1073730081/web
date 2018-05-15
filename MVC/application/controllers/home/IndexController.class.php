<?php

//application/controllers/backend/IndexController.class.php

class IndexController extends BaseController
{
    public function indexAction()
    {
        $music = new IndexModel('');
        $result = $music->index();
        $view = new viewModel;
        $view->setdata($result);
    }

    public function logincheckAction()
    {
        //session_start();
        $music = new IndexModel('users');
        /** 登录函数*/
        if ($_POST['submit'] == 'login')
        {
            if ((!isset($_SESSION['user_id'])) && ($_POST['submit'] == 'login'))
            {
                $result = $music->check();
                $view = new viewModel;
                $view->setdata($result);
            } else
            { //如果用户已经登录，则直接跳转到已经登录页面
                $home_url = 'loged.php';
                header('Location: ' . $home_url);
            }
        }
        /** 注册函数 */
        if ($_POST['submit'] == 'register')
        {
            $html = 'register';
            $register_view = new viewRegisterModel($html); //转到注册页面

        }
        /** 忘记密码*/
        if ($_POST['submit'] == '忘记密码')
        {
            $this->forgetpswAction();
        }
    }

    public function registerAction()
    {
        $customer = new IndexModel('');
        $result = $customer->register();

        $view = new viewModel($result['url']);
        $view->setdata($result);

    }

    public function forgetpswAction()
    {
        $fpw = new IndexModel('');
        $result = $fpw->forgetpassword();
        $view = new viewModel($result['url']);
        $view->setdata($result);
    }
    
    
    public function searchAction(){
        $search = new IndexModel('');
        if(isset($_POST['search'])){
            $music = $_POST['search'];
            $result = $search->search($music);
        }
        else{
            $result['error'] = "请输入要查询的内容";
        }
        
    }
    
    
    public function downloadAction(){
        
    }
    
    public function commentAction(){
        
    }
}

?>