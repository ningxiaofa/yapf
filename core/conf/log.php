<?php

return [
    'driver' => 'file',
    'option' => [
        // 'path' => KERNEL . '/' . 'log/' //之前的配置，优化如下：
        'path' => [
            'access' => KERNEL . '/' . 'log/access/',
            'exception' => KERNEL . '/' . 'log/exception/'
        ]
    ]
];
