<?php

namespace core\lib;

use Medoo\Medoo; //文档见: https://medoo.lvtao.net/doc.php

class model extends Medoo // \PDO [之前是继承\PDO]
{
    public function __construct()
    {
        /*$dbms = 'mysql';    //数据库类型
        $host = 'localhost';  //数据库主机名
        $dbName = 'test';     //使用的数据库
        $username = 'root';   //数据库连接用户名
        $passwd = 'rootroot'; //对应的密码
        $dsn = "$dbms:host=$host;dbname=$dbName";*/

        /*$databaseConf= conf::all('database');
        // p($databaseConf);
        $dsn = $databaseConf['dbms'] . ':host=' . $databaseConf['host'] . ';dbname=' . $databaseConf['dbname'];
        try{
            parent::__construct($dsn, $databaseConf['username'], $databaseConf['password']);
        }catch(\PDOException $exception){
           p($exception->getMessage());
        }*/

        //--------------------------------------------- 以上是继承\PDO的code
        $option = conf::all('database');
        parent::__construct($option);
    }
}