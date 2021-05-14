<?php
/**
 * DAOMySQLi类，用来访问、操作mysql数据库
 * 连接
 * 增删改查
 */
class DAOMySQLi
{
    private $host;
    private $user;
    private $pass;
    private $dbname;
    private $port;

    private $mysqli;    //保存mysqli对象

    private static $instance;

    //构造该方法私有化
    private function __construct($options)
    {
        $this -> host = isset($options['host'])?$options['host']:'';
        $this -> user = isset($options['user'])?$options['user']:'';
        $this -> pass = isset($options['pass'])?$options['pass']:'';
        $this -> dbname = isset($options['dbname'])?$options['dbname']:'';
        $this -> port = isset($options['port'])?$options['port']:'';

        //实例化mysqli对象
        $this -> mysqli = new mysqli($this->host,$this->user,$this->pass,$this->dbname,$this->port);
        if($this -> mysqli -> connect_error){
            echo '连接失败,详细信息如下:'.$this -> mysqli -> connect_error;
            exit();
        }
    }
    //克隆方法私有化，禁止在外面克隆
    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    //一个公共的静态方法
    public static function getSingleton($options)
    {
        if(!self::$instance instanceof self){
            self::$instance = new self($options);
        }
        return self::$instance;
    }

    //查询所有的数据
    public function fetchAll($sql)
    {
        //1. 执行sql语句,返回结果集
        $result = $this -> mysqli -> query($sql);
        if($result){
            $arr = [];
            while($row = $result -> fetch_assoc()){
                $arr[] = $row;
            }

            //释放结果集
            $result -> free();
            return $arr;
        }else{
            //说明sql语句有误
            echo 'SQL语句有误，详细信息如下:<br>'.$this-> mysqli -> error;
            exit();
        }
    }
    //查询一条数据
    public function fetchOne($sql)
    {
        $result = $this -> mysqli -> query($sql);
        if($result){
            $row = $result -> fetch_assoc();

            //先把结果集释放
            $result -> free();
            return $row;
        }else{
            //说明sql语句有误
            echo 'SQL语句有误，详细信息如下:<br>'.$this-> mysqli -> error;
            exit();
        }
    }
    //执行增删改的sql语句
    public function query($sql)
    {
        $result = $this -> mysqli -> query($sql);
        if($result){
            //执行成功
            $affected_rows = $this -> mysqli -> affected_rows;
            if($affected_rows > 0){
                //执行成功并影响到数据库
                return true;
            }else{
                //执行成功没有影响到数据库
                return false;
            }
        }else{
            //执行失败
            //说明sql语句有误
            echo 'SQL语句有误，详细信息如下:<br>'.$this-> mysqli -> error;
            exit();
        }
    }
}
