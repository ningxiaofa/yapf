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
        echo 'loadConf';
        /** @var $tmp 下面只是测试 配置文件中默认的控制和方法, 日志里记录的仍是loadConf方法 */
        $tmp = conf :: get('controller', 'route'); // index
        $tmp = conf :: get('action', 'route'); // index
    }

    /**
     * 测试 composer加载[1] [结合index.php]
     * filp/whoops
     */
    public function testWhoops()
    {
        /** 测试报错, 是否会使用我们美化的错误报错 */
        just_test_whoops();

        /*
        界面出现[如预期]:
        Error
        Call to undefined function
        app\controllers\just_test_whoops()
        */
    }

    /**
     * 测试 composer加载[2] [结合index.php]
     * symfony/var-dumper
     */
    public function testDump(){
        //测试 symfony/var-dumper 美化打印格式
        dump(['name' => "value"]); // 如预期
        exit('stop');


        /*
        界面如下:[颜色区分]
        array:1 [▼
          "name" => "value"
        ]

        stop
        */
    }

}