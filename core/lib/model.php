<?php

namespace core\lib;

class model extends \PDO
{
    public function __construct()
    {
        $dbms = 'mysql';      //数据库类型
        $host = 'localhost';  //数据库主机名
        $dbName = 'test';     //使用的数据库
        $username = 'root';   //数据库连接用户名
        $passwd = 'rootroot'; //对应的密码
        $dsn = "$dbms:host=$host;dbname=$dbName";
        try{
            parent::__construct($dsn, $username, $passwd);
        }catch(\PDOException $exception){
           p($exception->getMessage());
        }

    }
}