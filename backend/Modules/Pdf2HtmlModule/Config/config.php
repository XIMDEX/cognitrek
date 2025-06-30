<?php

return [
    // General configurations for the module
    'name' => 'Pdf2HtmlModule',
    'version' => '1.0.0',
    'script' => base_path('./converters/pdf2html.py'),

    // Register services
    'services' => [
        'conversion_service' => \Modules\Pdf2HtmlModule\Services\ConversionService::class,
    ],
];
