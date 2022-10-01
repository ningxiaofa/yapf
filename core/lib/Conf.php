<?php

namespace core\lib;

class Conf
{
    // Note: DIRECTORY_SEPARATOR 目录分隔符，在不同系统下，不同，该常量为解决平台兼容性
    static private $coreConfPath = APP_BASE_PATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR;

    static public $conf = [];

    /**
     * 加载配置文件中的配置项
     * @param $name
     * @param $file
     * @return mixed
     * @throws \Exception
     */
    static public function get($name, $file)
    {
        /**
         * 1. 判断文件是否存在
         * 2. 判断配置是否存在
         * 3. 缓存配置
         * 备注: 这里$file 要使用相同的路径[key],不然起不到避免重复加载的作用
         */
        if (isset(static::$conf[$file])) {
            return static::$conf[$file][$name];
        }
        // p(1); 用于检查是否多次加载 配合 app/controllers/indexController.php 中多次调用 conf::get();

        $filePath = static::$coreConfPath . $file . '.php';

        if (is_file($filePath)) {
            $conf = include $filePath;

            if (isset($conf[$name])) {
                static::$conf[$file] = $conf;
                return $conf[$name];
            } else {
                throw new \Exception('There is no such configuration item ' . $name);
            }
        } else {
            throw new \Exception('Configuration file not found ' . $file);
        }
    }

    static public function all($file)
    {
        if (isset(static::$conf[$file])) {
            return static::$conf[$file];
        }

        $filePath = static::$coreConfPath . $file . '.php';
        if (is_file($filePath)) {
            $conf = include $filePath;
            static::$conf[$file] = $conf;
            return $conf;
        } else {
            throw new \Exception('Configuration file not found ' . $file);
        }
    }
}
