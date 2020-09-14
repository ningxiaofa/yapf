<?php

/**
 * 入口文件
 * 作用[流程]:
 * 1.定义常量
 * 2.加载函数库
 * 3.启动框架
 */

defined('APP_BASE_PATH') or define('APP_BASE_PATH', realpath('./'));
defined('CORE') or define('CORE', APP_BASE_PATH . '/core');
defined('APP') or define('APP', APP_BASE_PATH . '/app');
// defined('PUBLIC_PATH') or define('PUBLIC_PATH', APP_BASE_PATH . '/public'); // 使用TBD  至于使用PUBLIC常量名报错的原因TBD
defined('MODULE') or define('MODULE', 'app');

/** 应该根据[检测]环境而定, 方法有很多, 这里用的是HTTP_HOST检测的方式*/
$env = ['imooc.test']; // 非生产环境
if(in_array($_SERVER['HTTP_HOST'], $env)){
    defined('DEBUG') or define('DEBUG', true);
}else{
    defined('DEBUG') or define('DEBUG', false);
}

/** [使用composer之前] 引入composer的vendor的类 [ Register The Auto Loader ] */
require __DIR__.'/vendor/autoload.php';

if (DEBUG){
    ini_set('display_errors', 'On');

    /** 使用Whoops报错[下面官方最简单的用法] */
   /* $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();*/

    //或者[自定义报错信息]

    $whoops = new \Whoops\Run;
    $option = new \Whoops\Handler\PrettyPageHandler();
    $errorTile = '框架出错了';
    $option->setPageTitle($errorTile);
    $whoops->pushHandler($option);
    $whoops->register();

} else {
    ini_set('display_errors', 'Off');
}

include CORE . '/common/functions.php';

include CORE . '/kernel.php';

/**
 * 加载路由类, 有三个步骤
 * 1. 需要一个方法 spl_autoload_register 作用: 当我们new一个类时, 如果不存在, 就会触发这个方法, 给这个方法[函数]传一个参数.
 * 2.
 */
spl_autoload_register('\core\kernel::load'); //要带上命令空间
\core\kernel::run();