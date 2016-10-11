<?php

/**
 * User: keven
 * Date: 2016/10/11
 * Time: 20:08
 */
class PDOMySQL
{
    public static $connectConfig = [];//设置连接参数的配置信息
    public static $instance = null;//保存PDO实例
    public static $pConnect = false;//是否开启长连接
    public static $dbVersion = null;//保存数据库版本
    public static $isConnected = false;// 是否连接成功
    public function __construct($dbConfig='')
    {
        if(class_exists("PDO")){
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
                'dsn'=>DB_TYPE.':host='.DB_HOST.'dbname='.DB_NAME,
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
             self::$dbVersion = self::$instance->getAttribute(contant("PDO::ATTR_SERVICE_VERSION"));
            self::$isConnected = true;
            unset($dbConfig);
        }
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