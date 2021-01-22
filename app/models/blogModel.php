<?php

namespace app\models;

use core\common\session;

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

        foreach (static::$fill as $key) {
            $ret[$key] = $data[$key];
        }

        // Fill created_user, updated_user
        $userinfo = (new session())::get('userinfo');
        if (empty($userinfo)) {
            return;
        }
        $ret['created_user'] = (int)$userinfo['id'];
        $ret['updated_user'] = (int)$userinfo['id'];

        return array_merge($ret, $this->_fillTimestamp());
    }

    protected function _fillTimestamp()
    {
        if (!empty(static::$timestamp)) {
            $data = [];

            $timestamp = time();
            foreach (static::$timestamp as $key) {
                $data[$key] = $timestamp;
            }

            return $data;
        }
    }
}
