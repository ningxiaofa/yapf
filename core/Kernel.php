<?php

namespace core;

use app\controller;
use core\lib\log;
use \Exception;

class Kernel
{
    //处于性能的考虑[假如类已引入过一次,就不要重复引入, 这里加个临时变量[属性]来储存已经加载好的类]
    static public $classMap = [];
    public $assign = [];
    static public $controllerPath = APP . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR;
    static public $viewPath = APP . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR;

    static public function run()
    {
        try {
            //p('ok');
            //后面添加[启动加载日志类]
            \core\lib\log::init();

            $route = new \core\lib\Route(); //自动加载成功
            // p($route); exit;
            $ctrlClass = $route->controller; // index
            $action = $route->action; // index

            $controllerName = $ctrlClass . 'Controller';
            $fileController = static::$controllerPath . $controllerName . '.php';
            // p($fileController);
            // Windows: G:\phpstudy_pro\WWW\front_backend\yapf\app\controllers\indexController.php
            // Mac: /Users/huangbaoyin/Documents/Env/docker-lnmp-dev-env-sh/html/yapf.test/app/controllers/indexController.php
            // Docker: /var/www/html/yapf.test/app/controllers/indexController.php
            $controller = '\\' . MODULE . '\controllers\\' . $controllerName;
            if (is_file($fileController)) {
                include $fileController;
                $controller = new $controller();
                // 下面if判断自行添加[TBD]
                // exit('stop');
                if (!method_exists($controller, $action)) {
                    // exit('stop');
                    throw new Exception('NOT FOUND ACTION: ' . $action . ' OF CONTROLLER: ' . $controllerName, 404);
                }
                $controller->$action();
                // 系统敏感位置, 打上log [为测试 日志类加载]
                log::log('ACCESS  CONTROLLER: ' . $controllerName . '  ' . 'ACTION: ' . $action);
            } else {
                throw new Exception('NOT FOUND CONTROLLER: ' . $controllerName, 404);
            }
        } catch (Exception $e) {
            // 根据Code做针对性处理
            switch ($e->getCode()) {
                case 404:
                    include_once(static::$viewPath . '404.php');
                    break;
                default:
                    break;
            }

            //记录系统异常log, 可以考虑保持开启，或者 关闭,出现为问题时,帮助进行定位问题.
            log::log('CODE: ' . $e->getCode() . ', MESSAGE: ' . $e->getMessage(), 'log', 'exception');
            //exit; // 加不加，都行，因为这里已经是代码执行的终点,但是如果还想做额外的处理，就不要添加 exit;
        }
    }

    static function load($class)
    {
        // 自动加载类库
        // new \core\route(); //正常来说, 应该引入route类, 然后这么去写.
        // 但是因为route类没有include进来, 就会触发index.php[入口文件]中的spl_autoload_register()方法中
        // 的kernel::load方法, 该方法需要传递一个参数, 这个参数就是我们'需要自动引入的类'.
        // $class = '\core\route';

        // 在这个类中要实现的功能是:
        // 把$class = '\core\route'; 转化为 下面的路径
        // APP_BASE_PATH . '/core/route.php';

        //$class = serializePath($class, '\\', '\\'); // 输出: \core\route 下同
        //$class = '\\' . $class;

        if (isset(self::$classMap[$class])) {
            return true;
        } else {
            $class = serializePath('/' . $class);
            $file = serializePath(APP_BASE_PATH . $class . '.php', '\\', '/');
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
        if (is_file($file)) {
            // p($this->assign);exit;
            // 将数组值打算, 每一个都变成一个单独的变量
            // 如: ['data' => 'Hello World !', 'title' => 'this is a tile !'] ==> $data = 'Hello World !', $title = 'this is a tile !'
            extract($this->assign); // 不能使用变量接收, 否则include的文件访问不到变量. 只能访问到用于接收的变量的值 值为count($this->assign)
            include $file;
        }
    }
}
