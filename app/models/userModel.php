<?php

namespace app\models;

class userModel extends baseModel
{
    public $table = 'users';

    static public $fields = [
        // 应该通过ORM进行映射获取 TBD, 也不会显示地定义
    ];

    // White and black list just for write data into database
    // White list [Include the fields of filling]
    static public $fill = [
        'username',
        'password',
        'email'
    ];

    static public $timestamp = [
        'created_at',
        'updated_at'
    ];

    // Black list [Exclude the fields of filling]
    static public $blackList = [
        // TBD
    ];

    public function fillData($data)
    {
        $ret = [];

        foreach(static::$fill as $key) {
            if($key == 'password'){
                $ret[$key] = md5(md5($data[$key]));
                continue;
            }
            $ret[$key] = $data[$key];
        }

        return array_merge($ret, $this->_fillTimestamp());
    }

    protected function _fillTimestamp()
    {
        if(!empty(static::$timestamp)){
            $data = [];

            $timestamp = time();
            foreach(static::$timestamp as $key) {
                $data[$key] = $timestamp;
            }
            
            return $data;
        }
    }

}