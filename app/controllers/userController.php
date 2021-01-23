<?php

namespace app\controllers;

use app\models\userModel;
use core\common\session;

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

        return success($rows);
    }

    /**
     * User detail
     */
    public function detail() {
        $id = getParams('id');
        $model = new userModel();
        $row = $model->getOne($id);

        return success($row);
    }

    /**
     * 登录
     */
    public function login()
    {
        $params = getParams();
        // 1. Validate whether logined
        if($userinfo = $this->_isLogined()){
            return success($userinfo, 'Already logined');
        };        

        // 2. Validate parameters and username/password whether correct
        list($msg, $userinfo) = $this->_loginValidate($params);
        if(!empty($msg)) return fail($msg);

        // 3. Write user info to session
        (new session)::set('userinfo', $userinfo);
        
        // 4. Return sucees
        return success($userinfo, 'login success');
    }

    /**
     * Check whether logined
     */
    private function _isLogined()
    {
        return (new session())::get('userinfo');
    }

    /**
     * Validate parameters and username/password whether correct
     */
    private function _loginValidate($params)
    {
        $msg = '';
        if(empty($params['username']) || empty($params['password'])) {
            $msg = 'username/password does not exist';
        }

        // Query user info from data table
        $userinfo = (new userModel())->getOneByWhere([
            'id',
            'username',
            'password',
            'email'
        ], [
            'username' => $params['username']
        ]);
    
        if(empty($userinfo) || $userinfo['password'] !== md5(md5($params['password']))) {
            $msg = 'username/password is wrong';
        }
        
        unset($userinfo['password']);

        return [$msg, $userinfo];     
    }

    /**
     * 注册
     * Also using ->insert()
     */
    public function register()
    {
        $params = getBodyParams();
        // 1.Validate parameters
        $msg = $this->_validate($params);
        if($msg) return fail($msg);

        // 2.Clean up the data
        $model = new userModel();
        $data = $model->fillData($params);

        // 3.Write to database
        $id = $model->add($data);
        if($id){
            return success(['id' => $id], 'Register success');
        }
        
        return fail('Register fail');
    }

    /**
     * Validate params whether correct
     */
    private function _validate($params)
    {
        $msg = '';
        if(!$params['username'] || !$params['password']) $msg = 'username/password not exist';
        if($params['password'] !== $params['password_confirm']) $msg = 'password_confirm is different from password';
        if($params['email'] && !preg_match('/^[A-Za-z\d]+([-_.][A-Za-z\d]+)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,4}$/', $params['email'])) {
            $msg = 'email format incorrect';
        }
        return $msg;
    }

    public function logout()
    {
        $session = new session();
        $userinfo = $session::get('userinfo');
        $session::clear('userinfo');
        return success($userinfo ? $userinfo : NULl, $userinfo ? 'Logout success' : 'Already logout');
    }

}
