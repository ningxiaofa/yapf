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
 * return arry
 */
if (!function_exists('getQsParams')) {
    function getQsParams($key = NULL)
    {
        if(!$_SERVER['QUERY_STRING']) return [];

        $strArr = explode('&', trim($_SERVER['QUERY_STRING'], '&'));
        $paramArr = [];
        foreach($strArr as $value){
            $valueArr = explode('=', $value);
            $paramArr[$valueArr[0]] = $valueArr[1];
        }

        return $key ? $paramArr[$key] : $paramArr;
    }
}

/**
 * Get request url params
 * return arry
 */
if (!function_exists('getUrlParams')) {
    function getUrlParams($key =NULL)
    {
        return $key ? $_GET[$key] : $_GET;
    }
}

/**
 * Get request body params
 * return array/string
 */
if (!function_exists('getBodyParams')) {
    function getBodyParams($key = NULL)
    {
        $params = [];

        $contentType = $_SERVER['CONTENT_TYPE'];
        if ($contentType == 'application/json') {
            $params = json_decode(file_get_contents('php://input'), true);
        } else if ($contentType == 'application/x-www-form-urlencoded') {
            $params = $_POST;
        } else if (stripos($contentType, 'multipart/form-data') > -1) {
            $params = $_POST;
        }

        return $key ? $params['$key'] : $params;
    }
}

/**
 * Get request total params
 * return array/string
 */
if (!function_exists('getParams')) {
    function getParams($key = NULL)
    {
        $paramArr = array_merge(getUrlParams(), getBodyParams());
        if($key){
            return $paramArr[$key] ? $paramArr[$key] : NULL;
        }
        return $paramArr;
    }
}
