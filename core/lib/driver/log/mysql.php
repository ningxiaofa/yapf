<?php

namespace core\lib\driver\log;

class mysql
{
    // 这里应该是存储到数据库中的逻辑,暂时省略.
    // 改进: 应该面向接口编程.
    public function log($name)
    {
        p($name);
    }
}