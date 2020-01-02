<?php
require_once 'i_DAOPDO.interface.php';
class DAOPDO implements i_DAOPDO{
    private $host;//服务器地址
    private $user;//用户名
    private $pass;//密码
    private $dbname;//数据库名
    private $port;//端口号
    private $charset;//字符集
    private $pdo;
    private static $instance;//静态的保存实例对象的属性
    private function __clone()
    {
        // TODO: Implement __clone() method.
    }
    private function __construct($options)
    {
        $this->host=isset($options['host'])?$options['host']:'loaclhost';//给服务器地址赋值
        $this->user=isset($options['user'])?$options['user']:'root';//给用户名赋值
        $this->pass=isset($options['pass'])?$options['pass']:'root';//给密码赋值
        $this->dbname=isset($options['dbname'])?$options['dbname']:'test';//给数据库赋值
        $this->port=isset($options['port'])?$options['port']:'3306';//给端口号赋值
        $this->charset=isset($options['charset'])?$options['charset']:'utf8';//给字符集赋值
        try{
            $dsn="mysql:host=$this->host;dbname=$this->dbname;charset=$this->charset";
            $user=$this->user;
            $pass=$this->pass;
            $this->pdo=new PDO($dsn,$user,$pass);
        }catch (PDOException $e){
            echo '连接失败,错误信息如下'.$e->getMessage();
            exit;//连接失败以后代码不向下执行
        }
    }
    //查询全部
    public function fetchAll($sql){
        $pdo_statement=$this->pdo->query($sql);
        if ($pdo_statement==false){
            echo 'sql语句有问题'.$this->pdo->errorInfo()[2];
            die();
        }
        //  返回查询的二维关联数组
        return $pdo_statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //查询单条
    public function fetchRow($sql){
        $pdo_statement=$this->pdo->query($sql);
        if ($pdo_statement==false){
            echo 'sql语句有问题'.$this->pdo->errorInfo()[2];
            die();
        }
        //  返回查询的一维关联数组
        return $pdo_statement->fetch(PDO::FETCH_ASSOC);
    }
    //查询某个字段
    public function fetchOne($sql){
        $pdo_statement=$this->pdo->query($sql);
        if($pdo_statement==false){
            echo 'sql语句有问题'.$this->pdo->errorInfo()[2];
            die();
        }
        return $pdo_statement->fetchColumn();

    }
    //增删改
    public function query($sql){
        $affect_rows=$this->pdo->exec($sql);
        if($affect_rows==false){
            echo 'sql语句问题'.$this->pdo->errorInfo()[2];
            die();
        }
        if($affect_rows>0){
            return true;
        }else{
            return false;
        }
    }
    //     提供一个公有的对外公开的创造对象的方法
    public static function getSingleton($options){
        if(!self::$instance instanceof self){
            self::$instance=new self($options);
        }
        return self::$instance;//返回对象
    }
    //添加引导
    public function quote($data){
        return $this->pdo->quote($data);
    }
    //获取增加成功的id号
    public function getInsertId(){
        return $this->pdo->lastInsertId();
    }
}
$configs=array(
    'host'=>'localhost',
    'user'=>'root',
    'pass'=>'root',
    'dbname'=>'test',
    'port'=>'3306',
    'charset'=>'utf8'
);
//$daopdo=DAOPDO::getSingleton($configs);
//$sql="insert into employ (id,yuame,sal,city)  values (null,'tom',5000,'天津')";
//$res=$daopdo->query($sql);
//var_dump($res);