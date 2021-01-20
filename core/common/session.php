<?php

namespace core\common;

class session
{
    public function __construct()
    {
        // Check if Session is enabled    /// Note: 可以修改php.ini配置: session.auto_start = 1
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

    }

    /**
     * Set session
     * @param String $name session name
     * @param Mixed $data session info
     * @param Integer $expire session expired time
     * @return Mixed
     */
    static public function set($name, $data, $expire = 600)
    {
        $session_data = [];
        $session_data['data'] = $data;
        $session_data['expire'] = time() + $expire;
        return $_SESSION[$name] = $session_data;
    }

    /**
     * Get session
     * @param String $name session name
     * @return Mixed
     */
    static public function get($name)
    {
        if (isset($_SESSION[$name])) {
            if ($_SESSION[$name]['expire'] > time()) {
                return $_SESSION[$name]['data'];
            } else {
                self::clear($name);
            }
        }

        return false;
    }

    /**
     * Clear some session
     * @param String $name session name
     */
    static public function clear($name)
    {
        unset($_SESSION[$name]);
    }

    /**
     * Clear the current session
     * @param String $name session name
     */
    static public function clearAll()
    {
        session_destroy();
    }

    // session_start();
    // $data = '123456';
    // session::set('test', $data, 10);
    // echo session::get('test'); // 未过期，输出
    // sleep(10);
    // echo session::get('test'); // 已过期
}
