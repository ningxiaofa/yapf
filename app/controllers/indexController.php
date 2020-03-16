<?php

namespace app\controller;

use app\models\user;
use \PDO;

class indexController
{
    public function index()
    {
        p('it is index action of indexController !');
        //test model class load
        $model = new \core\lib\model();
        $sql = "SELECT * FROM test";  //数据表的名字不能为 table[关键字] 这里改为test
        $ret = $model->query($sql);
        p($ret->fetchAll(PDO::FETCH_CLASS)); // 返回 二维数组[内层数组为关联数组[列名为key]]
        // p($ret->fetch(PDO::FETCH_ASSOC)); // 获取一行数据, 以关联数组形式
    }
}