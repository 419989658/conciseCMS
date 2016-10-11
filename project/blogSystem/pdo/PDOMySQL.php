<?php

/**
 * User: keven
 * Date: 2016/10/11
 * Time: 20:08
 */
require 'config.php';
class PDOMySQL
{
    public static $connectConfig = [];//设置连接参数的配置信息
    public static $instance = null;//保存PDO实例
    public static $pConnect = false;//是否开启长连接
    public static $dbVersion = null;//保存数据库版本
    public static $isConnected = false;// 是否连接成功
    public static $pdoStatement = null; // 返回PDOStatementd对象
    public static $sqlStr = null; //最后执行的SQL语句

    /**
     * PDOMySQL constructor.
     * @param string $dbConfig
     */
    public function __construct($dbConfig='')
    {
        header("Content-type:text/html;charset=utf-8");
        if(!class_exists("PDO")){
            self::throw_exception('不支持PDO,请先开启');
        }
        if(!is_array($dbConfig)){
            $dbConfig=[
                'hostname'=>DB_HOST,
                'username'=>DB_USER,
                'password'=>DB_PWD,
                'dbname'=>DB_NAME,
                'hostport'=>DB_PORT,
                'dbms'=>DB_TYPE,
                'dsn'=>DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME.';port='.DB_PORT,
            ];
        }
        if(empty($dbConfig['hostname'])) self::throw_exception('没有定义数据库配置');
        self::$connectConfig=$dbConfig;
        if(empty(self::$connectConfig['params'])) self::$connectConfig['params']=[];
        if(!isset(self::$instance)){
            if(self::$pConnect){
                self::$connectConfig['params'][constant("PDO::ATTR_PERSISTENT")] = true;//设置开启长链接
            }
            try{
                self::$instance = new PDO(
                    self::$connectConfig['dsn'],
                    self::$connectConfig['username'],
                    self::$connectConfig['password'],
                    self::$connectConfig['params']);
            }catch (PDOException $e){
                self::throw_exception($e->getMessage()) ;
            }
            if(!self::$instance){
                self::throw_exception("PDO链接错误");
                return false;
             }
             self::$instance->exec("SET NAMES ".DB_CHARSET);
             self::$dbVersion = self::$instance->getAttribute(constant("PDO::ATTR_SERVER_VERSION"));
            self::$isConnected = true;
            unset($dbConfig);
        }
    }

    public static function getAll($sql = null)
    {
        if($sql != null){
            self::query($sql);
        }
        $result = self::$pdoStatement->fetchAll(constant("PDO::FETCH_ASSOC"));
        return $result;
    }

    public static function query($sql = '')
    {
        $instance = self::$instance;
        if(!$instance) return false;
        if(!empty(self::$pdoStatement)) self::free(); //释放上一次操作遗留的结果集
        self::$sqlStr = $sql;
        self::$pdoStatement = self::$instance->prepare(self::$sqlStr);
        $res = self::$pdoStatement->execute();
        self::haveErrorThrowException();
        return $res;
    }

    public static function haveErrorThrowException()
    {
        $obj = empty(self::$pdoStatement)?self::$pdoStatement:self::$instance;
        $arrError = $obj->errorInfo();
        print_r($arrError);
    }
    /**
     * 释放结果集
     */
    public static function free()
    {
        self::$pdoStatement = null;
    }

    /**
     * 输出错误异常
     * @param $errMsg
     */
    public static function throw_exception($errMsg)
    {
        echo "<div style='width:80%;background-color:#ABCDEF;color:black;font-size:16px'>{$errMsg}</div>";
    }

}

$pdoMysql = new PDOMySQL();
$sql = 'select * from test';
$pdoMysql::getAll($sql);
print_r($pdoMysql);