<?php

return [
    'driver' => 'file',
    'option' => [
        // 'path' => KERNEL . '/' . 'log/' //之前的配置，优化如下：
        'path' => [
            'access' => APP_BASE_PATH . '/' . 'log/access/',
            'exception' => APP_BASE_PATH . '/' . 'log/exception/'
        ]
    ]
];
