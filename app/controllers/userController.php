<?php

namespace app\controllers;

use app\models\userModel;

class userController extends \core\kernel
{
    public function index()
    {
        exit('Just test');
        $model = new userModel();
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

    /**
     * User list
     */
    public function list()
    {
        $model = new userModel();
        $rows = $model->all();

        return [
            'code' => 1,
            'msg' => 'success',
            'rows' => $rows
        ];
    }

    /**
     * User detail
     */
    public function detail() {
        $id = getParams('id');
        $model = new userModel();
        $row = $model->getOne($id);

        return [
            'code' => 1,
            'msg' => 'success',
            'row' => $row
        ];
    }

    public function login()
    {
        // p('login');
        return getParams();
    }

    public function register()
    {
        // p('register');
        $data = file_get_contents('php://input');
        p($data);
        //url 多余部分转换成 GET参数 http://imooc.test/index/index/id/1 ==> id=1
        // index/index/id/1 ...  ==> id/1 ...
        //p($pathArr);
    }
}
