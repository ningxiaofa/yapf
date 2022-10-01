<?php

return [
    'driver' => 'file',
    'option' => [
        'path' => [
            'access' => RUNTIME . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . 'access' . DIRECTORY_SEPARATOR,
            'exception' => RUNTIME . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . 'exception' . DIRECTORY_SEPARATOR,
        ],
    ],
];