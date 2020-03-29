<?php

namespace core;

use app\controller;
use core\lib\log;

class imooc
{
    //处于性能的考虑[假如类已引入过一次,就不要重复引入, 这里加个临时变量[属性]来储存已经加载好的类]
    static public $classMap = [];
    public $assign = [];

    static public function run()
    {
        //p('ok');
        //后面添加[启动加载日志类]
        \core\lib\log::init();

        $route = new \core\lib\route(); //自动加载成功
        //p($route);
        $ctrlClass = $route->controller; // index
        $action = $route->action; // index

        $controllerName = $ctrlClass . 'Controller';
        $fileController = APP . '/controllers/' . $controllerName . '.php';
        //p($fileController); G:\phpstudy_pro\WWW\front_backend\imooc/app/controllers/indexController.php
        $controller = '\\' . MODULE . '\controllers\\' . $controllerName;
        if(is_file($fileController)){
            include $fileController;
            $controller  =  new $controller();
            // 下面if判断自行添加[TBD]
            if(!method_exists($controller ,$action)){
                throw new \Exception('找不到控制器中的方法 ' . $action);
            }
            $controller->$action();
            //系统敏感位置, 打上log [为测试 日志类加载 ]
            log::log('Call controller: '. $controllerName . '   ' . 'action: ' . $action );
        }else{
            throw new \Exception('找不到控制器 ' . $controllerName);
        }
    }

    static function load($class)
    {
        // 自动加载类库
        // new \core\route(); //正常来说, 应该引入route类, 然后这么去写.
        // 但是因为route类没有include进来, 就会触发index.php[入口文件]中的spl_autoload_register()方法中
        // 的imooc::load方法, 该方法需要传递一个参数, 这个参数就是我们'需要自动引入的类'.
        // $class = '\core\route';

        // 在这个类中要实现的功能是:
        // 把$class = '\core\route'; 转化为 下面的路径
        // IMOOC . '/core/route.php';

        //$class = serializePath($class, '\\', '\\'); // 输出: \core\route 下同
        //$class = '\\' . $class;

        if (isset(self::$classMap[$class])) {
            return true;
        } else {
            $class = serializePath('/' . $class);
            $file = serializePath(IMOOC . $class . '.php', '\\', '/');
            if (is_file($file)) {
                include $file;
                self::$classMap[$class] = $class;
            } else {
                return false;
            }
        }

    }

    /**
     * 视图模板赋值
     * @param $name
     * @param $value
     */
    public function assign($name, $value)
    {
        $this->assign[$name] = $value;
    }

    public function display($file)
    {
        $file = APP . '/views/' . $file;
        if(is_file($file)){
            // p($this->assign);exit;
            // 将数组值打算, 每一个都变成一个单独的变量
            // 如: ['data' => 'Hello World !', 'title' => 'this is a tile !'] ==> $data = 'Hello World !', $title = 'this is a tile !'
            extract($this->assign); // 不能使用变量接收, 否则include的文件访问不到变量. 只能访问到用于接收的变量的值 值为count($this->assign)
            include $file;
        }
    }
}