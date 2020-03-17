<?php

namespace app\controllers;

use app\models\user;
use \PDO;

class indexController extends \core\imooc
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

    public function loadView()
    {
        $data = 'Hello World !';
        $this->assign('data', $data);
        $this->assign('title', 'this is a title !');
        $file = 'index.html';
        $file = 'test.txt';  // 使用txt后缀 php/浏览器 也依然可以解析php脚本以及HTML文档
        $this->display($file);
    }

}