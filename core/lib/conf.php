<?php

namespace core\lib;

class conf
{
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
        if(isset(static::$conf[$file])){
            return static ::$conf[$file][$name];
        }
        // p(1); 用于检查是否多次加载 配合 app/controllers/indexController.php 中多次调用 conf::get();

        $filePath = KERNEL .'\core\conf\\' . $file . '.php';
        if(is_file($filePath)){
            $conf = include $filePath;

            if(isset($conf[$name])){
                static :: $conf[$file] = $conf;
                return $conf[$name];
            }else{
                throw new \Exception('没有该配置项 ' . $name);
            }
        } else {
            throw new \Exception('找不到配置文件 ' . $file);
        }
    }

    static public function all($file)
    {
        if(isset(static::$conf[$file])){
            return static ::$conf[$file];
        }

        $filePath = KERNEL .'\core\conf\\' . $file . '.php';
        if(is_file($filePath)){
            $conf = include $filePath;
            static::$conf[$file] = $conf;
            return $conf;
        } else {
            throw new \Exception('找不到配置文件 ' . $file);
        }
    }

}