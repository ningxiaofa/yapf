<?php

namespace app\controllers;

use app\models\user;
use \PDO;
use core\lib\model;
use core\lib\conf;
use app\models\testModel;

class indexController extends \core\kernel
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

    /**
     * 测试加载Medoo 这种方式不推荐, 应该使用model基类方式
     */
    public function testMedoo()
    {
        $model = new model();
        dump($model);

        //查询语句
        $data = $model->select("test", [
            "name",
            "id"
        ], [
            "id[>]" => 1
        ]);

        dump($data);
    }

    //插入语句
    public function insert()
    {
        $model = new testModel();
        $model->insert($model->table, [
            "name" => "foo123",
        ]);

        dump($model->id());
    }

    /**
     * 使用model基类[继承]方式 app/models/testModel.php
     */
    public function testBaseModel()
    {
        $testModel = new testModel();

        $ret = $testModel->all();

        dump($ret);
    }

    /**
     * 获取一条记录 $id 应该如何传递进来?
     */
    public function getOne()
    {
        $id = 4;
        $ret = (new testModel())->getOne($id);

        dump($ret);
    }

    //写入[更新与新增]
    public function save()
    {
        //测试请求参数数据
        $array = [
            'id' => 1,  //带有id就是更新
            'name' => 'just to test'
        ];
        $where = ['name' => 'just to test']; //一般有id就没有where条件
        $ret = (new testModel())->save($array, $where);
        dump($ret);
    }

    //根据id更新
    public function setOne()
    {
        //模拟接收参数
        $data = [
            'name' => 'hello world!',
        ];
        $ret = (new testModel())->setOne(4, $data);
        //return $ret;

        dump($ret);
    }

    //新增
    public function addOne()
    {
        //参数模拟
        $data = [ //同时插入多条
           [ 'name' => 'hello william !'],
           [ 'name' => 'hello william 123!'],
        ];
        $ret = (new testModel())->add($data);
        dump($ret);
        //return $ret;
    }

    //删除
    public function delById()
    {
        //模拟参数列表
        $id = [ //删除多条
            1,
            2,
            3
        ];
        //删除一条
        //$id = 1;

        $ret = (new testModel())->delById($id);
        dump($ret);
        //return $ret;
    }

    //删除[where条件]
    public function delByWhere()
    {
        //模拟参数
        $where = [
            "AND" => [
                "name[!]" => "foo",
                "age[>]" => 15,
            ]
        ];

        $ret = (new testModel())->delByWhere($where);
        dump($ret);
        //return $ret;
    }

}