<?php

return [
    'mode'                  => 'utf-8',
    'format'                => 'A4',
    'author'                => '',
    'subject'               => '',
    'keywords'              => '',
    'creator'               => 'Laravel Pdf',
    'display_mode'          => 'fullpage',
    'tempDir'               => base_path('../temp/'),

    'font_path' => base_path('/public/pdf_fonts/'),
    'font_data' => [
        'bangla' => [
            'R'  => 'Nirmala.ttf',    // regular font
            'useOTL' => 0xFF,
            'useKashida' => 75,
        ]
    ]

];
