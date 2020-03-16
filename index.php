<?php

/**
 * 入口文件
 * 作用[流程]:
 * 1.定义常量
 * 2.加载函数库
 * 3.启动框架
 */

define('IMOOC', realpath('./'));
define('CORE', IMOOC . '/core');
define('APP', IMOOC . '/app');
define('MODULE', 'app');

define('DEBUG', true);

if (DEBUG){
    ini_set('display_errors', 'On');
} else {
    ini_set('display_errors', 'Off');
}

include CORE . '/common/functions.php';

include CORE . '/imooc.php';

/**
 * 加载路由类, 有三个步骤
 * 1. 需要一个方法 spl_autoload_register 作用: 当我们new一个类时, 如果不存在, 就会触发这个方法, 给这个方法[函数]传一个参数.
 * 2.
 */
spl_autoload_register('\core\imooc::load'); //要带上命令空间
\core\imooc::run();