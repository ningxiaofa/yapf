<?php

namespace core\lib\driver\log;

use core\lib\conf;

class file
{
    public $path; // 日志储存位置

    public function __construct()
    {
        $this->path =  (conf::get('option', 'log'))['path'];
    }

    public function log($message, $file = 'log')
    {
        /**
         * 思路:
         * 1. 确定文件存储位置是否存在
         *  新建目录
         *
         * 2. 写入日志
         * 2.1注意点:
         * a. 写入日志的信息可能是数组形式, 要转码处理[json][数组/对象是不能直接存入文件中].
         * b. 写入日志内容应该追加写入
         * c. 文件内容应换行显示
         *
         * d. 如果系统并发量很高, 日志文件会很大,
         * 解决办法: 按照当前的时间分目录.即在路径中加入日期处理
         *
         * 3. 使用[打上]日志 具体何处暂省略.
         */

        $dirPath = $this->path . date('YmdH');
        if(!is_dir($dirPath)){
            mkdir($dirPath, '0777', true);
        }
        // p($dirPath . '/' . $file . '.php');
        // exit;
        $message = date('Y-m-d H:i:s ') . json_encode($message) . PHP_EOL; //换行显示
        $path = $dirPath . '/' . $file . '.php';
        return file_put_contents($path, $message, FILE_APPEND); //追加写入
    }
}