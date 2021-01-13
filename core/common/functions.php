<?php

/**
 * Print ro output
 */
if (!function_exists('p')) {
    function p($var)
    {
        if (is_bool($var)) {
            var_dump($var);
        } else if (is_null($var)) {
            var_dump(NULL);
        } else {
            echo "<pre style='position: relative; z-index: 1000; padding: 10px; 
        border-redius:5px; background: #F5F5F5; border: 1px solid #aaa; font-size: 14px; line-height: 18px; opacity: 0.9;'>
        " . print_r($var, true) . "</pre>";
        }
    }
}

/**
 * Serialize path
 */
if (!function_exists('serializePath')) {
    function serializePath($path, $seatch = '\\', $replace = '/')
    {
        if (!$path) {
            return false;
        }

        return str_replace($seatch, $replace, $path);
    }
}

/**
 * Get request queryString params
 */
if (!function_exists('getUrlParams')) {
    function getUrlParams()
    {
        $params = $_SERVER['REQUEST_URI'];
        // TBD
        return $params;
    }
}

/**
 * Get request body params
 */
if (!function_exists('getBodyParams')) {
    function getBodyParams()
    {
        $params = null;

        switch ($_SERVER['CONTENT_TYPE']) {
            case "application/json":
                $params = json_decode(file_get_contents('php://input'), true);
                break;
            case "application/x-www-form-urlencoded":
            case "application/x-www-form-urlencoded":
                $params = $_POST;
                break;
            default:
                break;
        }

        return $params;
    }
}
