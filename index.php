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

define('DEBUG', true);

if (DEBUG){
    ini_set('display_errors', 'On');
} else {
    ini_set('display_errors', 'Off');
}

include CORE . '/common/function.php';

include CORE . '/imooc.php';

\core\imooc::run();