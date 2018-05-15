<?php

class IndexModel extends Model
{
    public function index()
    {
        $login = array("username" => "");
        //$music =
        return $login;
    }

    public function check()
    {
        $ret = array(); //返回值

        if ((isset($_POST['submit'])) && ($_POST['submit'] == 'login'))
        { //用户提交登录表单时执行如下代码
            $sql = "select * from login where username = :username and password = :password";
            $sth = $this->db->prepare($sql);
            $username = $_POST['username'];
            $password = $_POST['password'];
            if (!empty($username) && !empty($password))
            {

                $query = array(":username" => $username, ":password" => $password);
                //用用户名和密码进行查询
                $result = $sth->execute($query);
                //若查到的记录正好为一条，则设置SESSION，同时进行页面重定向
                if ($result)
                {
                    if($sth->rowCount() == 1)
                    {
                        $row = $sth->fetch(PDO::FETCH_ASSOC);
                        //if (count($row) == 1)
                    
                        $_SESSION['user_id'] = $row['user_id'];
                        $_SESSION['username'] = $row['username'];
                        $ret += array('url' => 'loged.php');
                        return $ret;
                        //header('Location: ' . $home_url);
                    } else
                    { //若查到的记录不对，则设置错误信息
                        $ret += array('error_msg' =>
                                'Sorry, you must enter a valid username and password to log in.',
                                'url' => 'index','username' => $username);
                        return $ret;
                    }
                } else
                {
                    $ret += array('error_msg' =>
                            'Sorry, you must enter a valid username and password to log in.',
                            'url' => 'index','username' => $username);
                    return $ret;
                }
            }
            else{
                $ret += array('error_msg' => '请输入用户名密码',
                              'url' => 'index',
                              'username' => $username);
                return $ret;
            }
        }
    }
    
    
    
    //注册
    public function register(){
        $ret = array();
        if (isset($_POST['submit']) && $_POST['submit'] == '注册'){
            /** 用户名，密码，再次输入，邮箱。 user_id*/
            if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['repeat']) && !empty($_POST['mail'])){
                $username = $_POST['username'];
                $password = $_POST['password'];
                $repeat = $_POST['repeat'];
                $mail = $_POST['mail'];
                
                //改进使用prepare,execute
                $sql = "select * from login where username = '$username'";
                
                $result = $this->db->query($sql);
                if ($result->rowCount() >= 1){  /** 用户名重复*/
                    $ret += array('error_msg' => '用户名被占用',
                              'url' => 'register');
                              return $ret;
                }
                if ($password != $repeat){
                    $ret += array('error_msg' => '输入密码不一致',
                              'url' => 'register',
                              'username' => $username);
                              return $ret;
                }
                
                //correct
                $sql = "insert into login (username,password,mail) values ($username, $password, $mail)";
                if ($this->db->exec($sql)){
                    $ret += array('error_msg' => '注册成功',
                                'url' => 'index',
                              'username' => $username);
                              return $ret;
                }
            }
            else {
                $ret += array('error_msg' => '请完整输入信息',
                              'url' => 'register');
                return $ret;
            }
        }
    }
    
    
    
    //忘记密码
    public function forgetpassword(){
        $ret = array();
        $ret += array('error_msg' => '此功能未成功',
                              'url' => 'index');
        return $ret;
    }
    
    /** $music is an array()
     * return any result in songs
     */
    public function search($music){
        $song = array($music);
        $ret = array();
        $sql = "select * from songs where song_name = ? or author = ? or song_type = ?";
        $search = $this->db->prepare($sql);
        $ret += $search->execute($music);
        return $ret;
    }
    
    
    public function download(){
        
    }
    
    public function comment(){
        
    }
}

?>