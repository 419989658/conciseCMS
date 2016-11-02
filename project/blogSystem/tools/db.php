<?php

/**
 * User: sometimes
 * Date: 2016/10/31
 * Time: 22:31
 */
class db
{
    protected $mysqlli;
    protected $table;
    protected $opt;

    function __construct()
    {
        $this->config($this->tab_name);
    }

    protected function config($tab_name)
    {
        $this->mysqlli = new mysqli(DBHOST,DBUSER,DBPWD,DBNAME);
        if(mysqli_connect_errno()){
            echo "数据库连接失败".mysqli_connect_errno();
            exit();
        }
        $this->mysqlli->query("set NAMES 'GBK'");

    }
}