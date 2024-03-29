<?php

namespace core;

use core\lib\Log;
use core\lib\Route;
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
            // 初始化加载日志类
            Log::init();

            $route = new Route(); // 自动加载成功
            $ctrlClass = $route->controller; // index
            $action = $route->action; // index

            // 尽管PHP的class名不区分大小写，但是还是推荐统一严格遵守大小写
            $controllerName = ucfirst($ctrlClass) . 'Controller';

            // 仍自动加载 -- 记得要带上命名空间，[这里有个隐性要求： 命名空间与目录结构一一对应，]
            // 通过命令空间可以定位到文件所在的目录，从而引入类文件.
            $controller = '\\' . MODULE . '\controllers\\' . $controllerName;
            try {
                $controller = new $controller();
                // if中逻辑，可自行决定
                if (!method_exists($controller, $action)) {
                    throw new Exception('NOT FOUND ACTION: ' . $action . ' OF CONTROLLER: ' . $controllerName, 404);
                }
                $controller->$action();

                // 系统敏感位置, 打上log [为测试, 日志类加载]
                Log::log('ACCESS CONTROLLER: ' . $controllerName . '  ' . 'ACTION: ' . $action);
            } catch (\Throwable $th) {
                // p($th->getMessage()); // string(50) "Class '\app\controllers\Test1Controller' not found"
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

            // 记录系统异常log, 可以考虑保持开启，或者 关闭,出现为问题时,帮助进行定位问题.
            Log::log('CODE: ' . $e->getCode() . ', MESSAGE: ' . $e->getMessage(), 'log', 'exception');
            // exit; // 加不加，都行，因为这里已经是代码执行的终点 但是如果还想做额外的处理，就不要添加 exit;
            // 不过注意，有些进程守护程序，是依赖exit(1);中输出的数字的，比如：Supervisor
        }
    }

    static function load($class)
    {
        // 自动加载类库
        // new \core\lib\Route(); //正常来说, 应该引入Route类, 然后这么去写.
        // 但是因为Route类没有include进来, 就会触发index.php[入口文件]中的spl_autoload_register()方法中
        // 的Kernel::load方法[也就是该方法], 该方法需要传递一个参数, 这个参数就是我们'需要自动引入的类'.
        // $class = '\core\lib\Route'; // 带命名空间，作用：1. PHP语法要求，处于命名空间下的类，new时，必须带上命名空间 2. 对应到目录找到类文件，从而引入

        // 在这个类中要实现的功能是:
        // 把$class = '\core\lib\Route'; 转化为 下面的路径
        // APP_BASE_PATH . '/core/lib/Route.php';
        // $class = serializePath($class, '\\', '/'); // 输出: \core\lib\Route 下同
        // $class = '/' . $class;

        if (isset(self::$classMap[$class])) {
            return true;
        } else {
            $class = serializePath('/' . $class); // e.g.: core\lib\Route --> /core/lib/Route
            // /var/www/html/yapf.test/core/lib/Route.php，仅仅为了解决当出现不同平台[Windows/*nix]下同时存在正反斜线导致的bug -- TBD, 仍带测试确认
            $file = serializePath(APP_BASE_PATH . $class . '.php', '\\', '/'); 
            if (is_file($file)) {
                include $file;
                self::$classMap[$class] = $class;
            } else {
                return false;
            }
            return true;
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
