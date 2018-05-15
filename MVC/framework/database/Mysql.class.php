<?php

/**

*================================================================

*framework/database/Mysql.class.php

*Database operation class

*================================================================

*/

class Mysql{

    protected $conn = false;  //DB connection resources

    protected $sql;           //sql statement

   

    /**

     * Constructor, to connect to database, select database and set charset

     * @param $config string configuration array

     */

    public function __construct($config = array()){

        $host = isset($config['host'])? $config['host'] : 'localhost';

        $user = isset($config['user'])? $config['user'] : 'root';

        $password = isset($config['password'])? $config['password'] : '';

        $dbname = isset($config['dbname'])? $config['dbname'] : '';

        $port = isset($config['port'])? $config['port'] : '3306';

        $charset = isset($config['charset'])? $config['charset'] : 'UTF8';


        $this->conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname","$user","$password") or die('Database connection error');

//      mysqli_select_db($this->conn,$dbname) or die('Database selection error');
/** **********************************************************************
 * pdo防注入
 *
$dbh = new PDO("mysql:host=localhost; dbname=demo", "user", "pass");
$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //禁用prepared statements的仿真效果
$dbh->exec("set names 'utf8'"); 
$sql="select * from test where name = ? and password = ?";
$stmt = $dbh->prepare($sql); 
$exeres = $stmt->execute(array($testname, $pass));
******************************************************************************/
        $this->setChar($charset);

    }
    /**

     * Set charset

     * @access private

     * @param $charset string charset

     */

    private function setChar($charest){

        $sql = 'SET CHARACTER SET '.$charest;

        $this->conn->exec($sql);

    }
    
    
    /**
     * prepare
     * @acess public
     * @return $result, a PDO Statement; if fail return error or FALSE
     */
     public function prepare($sql){
        $this->sql = $sql;
        /**
         * 防止sql注入
         */
        $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);//禁用prepared statements的仿真效果
        // Write SQL statement into log

        $str = $sql . "  [". date("Y-m-d H:i:s") ."]" . PHP_EOL;

        file_put_contents("log.txt", $str,FILE_APPEND);
        
        $result = $this->conn->prepare($this->sql);
        
        return $result;
     }

    /**

     * Execute SQL statement

     * @access public

     * @param $sql string SQL query statement

     * @return $result，if succeed, return resrouces; if fail return error message and exit

     */
     public function query($sql){        

        $this->sql = $sql;

        // Write SQL statement into log

        $str = $sql . "  [". date("Y-m-d H:i:s") ."]" . PHP_EOL;

        file_put_contents("log.txt", $str,FILE_APPEND);

        $result = $this->conn->query($this->sql);

       

        if (! $result) {

            die($this->errno().':'.$this->error().'<br />Error SQL statement is '.$this->sql.'<br />');

        }

        return $result;

    }
    
    
    /**

     * Execute SQL statement

     * @access public

     * @param $sql string SQL query statement

     * @return $result，if succeed, return resrouces; if fail return error message and exit

     * 返回修改增加删除的行数，查询的返回0，调用die();
     */
     public function exec($sql){        

        $this->sql = $sql;

        // Write SQL statement into log

        $str = $sql . "  [". date("Y-m-d H:i:s") ."]" . PHP_EOL;

        file_put_contents("log.txt", $str,FILE_APPEND);

        $result = $this->conn->exec($this->sql);

       

        if (! $result) {

            die($this->errno().':'.$this->error().'<br />Error SQL statement is '.$this->sql.'<br />');

        }

        return $result;

    }
    
    /**
    Execute SQL statement

     * @access public

     * @param $arr is 

     * @return $result，if succeed, return TURE; if fail FALSE
    */
    public function execute($prepare,$array = array()){
        $list = array();
        
        for($i = 0;$i < sizeof($array);$i++){
            $row = $array[i];
            $result = $prepare->execute($row);
            $list+=$result;
        }
        return $list;

     }
    
    
    /** Get the first column of the first record
     * @access public
     * @param $sql string SQL query statement
     * @return return the value of this column
     */
     public function getOne($sql){
        $result = $this->query($sql);
        $row = $result->fetch();
        if($row){
            return $row[0];
        }else {
            return false;
        }
     }
     
     
     /**
      * Get one record
      * @access public
      * @param $sql SQL query statement
      * @return array associative array
      */
    public function getRow($sql){
        if($result = $this->query($sql)){
            $row = $result->fetch();
            return $row;
        } else {
            return false;
        }
    }
    
    
    /**
     * Get all records
     * @access public
     * @param $sql SQL query statement
     * @return $list an 2D array containing all result records
     */
    public function getAll($sql){
        $result = $this->query($sql);
        $list = array();
        while($row = $result->fetch()){
            $list[] = $row;
        }
        return $list;
    }
    
    
    /**
     * Get the value of a column
     * @access public
     * @param $sql string SQL query statement
     * @return $list array an array of the value of this column
     */
    public function getCol($sql){
        $result = $this->query($sql);
        $list = array();
        while($row = $result->fetch()){
            $list[] = $row[0];
        }
        return $list;
    }
    
    
    /**
     * Get last insert id
     */
    public function getInsertID(){
        return $this->conn->lastInsertId();
    }
    
    
    /**
     * Get error number
     * @access private
     * @return error number
     */
    private function errno(){
        return $this->conn->errorCode();
    
    }
    
    /**
     * Get error number
     * @access private
     * @return error
     */
    private function error(){
        return $this->conn->errorInfo();
    
    }

    
    /**
     * update messsage
     * @access public
     * @return bool
     */
    public function update($sql){
        return $this->conn->exec($sql);
    }
    
    
    
  }

?>