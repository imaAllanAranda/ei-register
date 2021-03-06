<?php

return [
    'mode' => 'utf-8',
    'format' => 'A4',
    'author' => '',
    'subject' => '',
    'keywords' => '',
    'creator' => 'Laravel Pdf',
    'display_mode' => 'fullpage',
    'tempDir' => base_path('../temp/'),
    'font_path' => base_path('public/fonts/'),
    'font_data' => [
        'calibri' => [
            'R' => 'CALIBRI.TTF',
            'B' => 'CALIBRIB.TTF',
            'I' => 'CALIBRII.TTF',
            'BI' => 'CALIBRIZ.TTF',
        ],
    ],
];
