<?php

namespace core\lib;

class log
{
    /**
     * 日志类 可以放在 文件, 数据库 , 甚至是缓存中[这个斟酌]
     *
     * 思路:
     * 1. 确定日志储存方式
     * Q: 如何调用储存方式?
     * A: 通过初始化方法,加载储存方式
     *
     * 2. 写日志
     */
    static public $class;

    static public function init()
    {
        //确定存储方式
        $driver = conf::get('driver', 'log');
        $class =  '\core\lib\driver\log\\' . $driver;
        //p($class);exit;
        static::$class = new $class;
    }

    static public function log($message, $file = 'log')
    {
        static::$class->log($message, $file);
    }

}
