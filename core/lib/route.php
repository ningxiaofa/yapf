<?php

namespace core\lib;

class route
{
    public $controller;
    public $action;

    public function __construct()
    {
        // p('route ok!');
        // xx.com/index.php/index/index  => xx.com/index/index ==> 访问的是index控制器中的index() 也可以处理 xx.com/index/indexView
        /**
         * 1. 隐藏index.php
         * 2. 获取url 参数部分
         * 3. 返回对应的控制器和方法
         */

        //p($_SERVER);
        if(isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '/'){
            // 特殊情况1: 当http://imooc.test/时, $_SERVER['REQUEST_URI'] = '/';
            // 特殊情况2: 当http://imooc.test/index

            // /index/index
            $path = $_SERVER['REQUEST_URI'];
            $pathArr = explode('/', trim($path, '/'));
            //p($pathArr);
            if(isset($pathArr[0])){
                $this->controller = $pathArr[0];
                unset($pathArr[0]);
            }
            if(isset($pathArr[1])){
                $this->action = $pathArr[1];
                unset($pathArr[1]);
            }else{
                $this->action = 'index';
            }

            //url 多余部分转换成 GET参数 http://imooc.test/index/index/id/1 ==> id=1
            // index/index/id/1 ...  ==> id/1 ...
            //p($pathArr);

            $pathArr = array_values($pathArr); //重新索引
            $count = count($pathArr);
            $i = 0;
            while($i < $count){
                if(isset($pathArr[$i + 1])){ //避免出现计数, 导致数组越界出现异常
                    $_GET[$pathArr[$i]] = $pathArr[$i + 1];
                }
                $i += 2;
            }

            // p($_GET); //ok !

        } else {
            $this->controller = 'index';
            $this->action = 'index';
        }
    }
}