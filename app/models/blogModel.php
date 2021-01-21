<?php

namespace app\models;

class blogModel extends baseModel
{
    public $table = 'blogs';

    static public $fields = [];

    static public $fill = [
        'title',
        'content'
    ];

    static public $timestamp = [
        'created_at',
        'updated_at'
    ];

    static public $blackList = [];

    public function fillData($data)
    {
        $ret = [];

        foreach($data as $key){
            $ret[$key] = $data[$key];
        }
        return array_merge($ret, $this->_fillTimestamp());
    }

    protected function _fillTimestamp()
    {
        if(!empty(static::$timestamp)){
            $data = [];

            $timestamp = time();
            foreach(static::$timestamp as $key){
                $data[$key] = $timestamp;
            }

            return $data;
        }
    }
}

