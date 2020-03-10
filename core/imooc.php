<?php

namespace core;

class imooc
{
    //处于性能的考虑[假如类已引入过一次,就不要重复引入, 这里加个临时变量[属性]来储存已经加载好的类]
    static public $classMap = [];

    static public function run()
    {
        //p('ok');
        $route = new \core\lib\route(); //自动加载成功
        //p($route);
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
}