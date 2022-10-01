<?php

return [
    'driver' => 'file',
    'option' => [
        'path' => [
            'access' => RUNTIME . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . 'access' . DIRECTORY_SEPARATOR,
            'except' => RUNTIME . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . 'except' . DIRECTORY_SEPARATOR,
        ],
    ],
];