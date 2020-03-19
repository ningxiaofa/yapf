<?php

namespace app\controllers;

use app\models\user;
use \PDO;
use core\lib\model;
use core\lib\conf;

class indexController extends \core\imooc
{
    /**
     * 加载控制器/模型 以及测试加载配置[数据库]类
     */
    public function index()
    {
        p('it is index action of indexController !');
        //test model class load
        $model = new model();
        $sql = "SELECT * FROM test";  //数据表的名字不能为 table[关键字] 这里改为test
        $ret = $model->query($sql);
        p($ret->fetchAll(PDO::FETCH_CLASS)); // 返回 二维数组[内层数组为关联数组[列名为key]]
        // p($ret->fetch(PDO::FETCH_ASSOC)); // 获取一行数据, 以关联数组形式
    }

    /**
     * 加载视图
     */
    public function loadView()
    {
        $data = 'Hello World !';
        $this->assign('data', $data);
        $this->assign('title', 'this is a title !');
        $file = 'index.html';
        $file = 'test.txt';  // 使用txt后缀 php/浏览器 也依然可以解析php脚本以及HTML文档
        $this->display($file);
    }

    /**
     * 配置类加载[将配置单独拿出来, 放到专门的配置文件中]
     */
    public function loadConf()
    {
        // echo 'loadConf';
        $tmp = conf :: get('controller', 'route');
        $tmp = conf :: get('action', 'route');
        p($tmp);
    }
}