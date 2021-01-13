<?php

namespace app\controllers;

use app\models\user;
use \PDO;
use core\lib\model;
use core\lib\conf;
use app\models\userModel;

class userController extends \core\kernel
{
    public function index()
    {
        $model = new userModel();

        // return [
        //     'code' => 1,
        //     'msg' => 'success',
        //     'data' => [
        //         1,2,3
        //     ]
        // ];

        $model->insert($model->table, [
            "username" => "foo123",
            "password" => "123456",
        ]);

        // dump($model->id());

        return [
            'code' => 1,
            'msg' => 'success',
            'id' => $model->id()
        ];
    }

    public function login()
    {
        // p('login');
        p($_SERVER);
        p($_POST);
    }

    public function register()
    {
        // p('register');
        p($_SERVER);
        $data = file_get_contents('php://input');
        p($data);
        //url 多余部分转换成 GET参数 http://imooc.test/index/index/id/1 ==> id=1
        // index/index/id/1 ...  ==> id/1 ...
        //p($pathArr);
    }
}
