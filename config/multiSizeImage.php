<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Optimize
    |--------------------------------------------------------------------------
    |
    | Defines if image should be optimized using spatie/image-optimizer (https://github.com/spatie/image-optimizer).
    |
    */
    'optimize' => true,

    /*
    |--------------------------------------------------------------------------
    | Keep original file
    |--------------------------------------------------------------------------
    |
    | Defines if the original file should be kept.
    |
    */
    'keep_original_file' => false,

    /*
    |--------------------------------------------------------------------------
    | Keep original name
    |--------------------------------------------------------------------------
    |
    | Defines if the original file name should be kept.
    | If false one will be auto-generated.
    | The user can also pass a custom name to MultiSizeImage processImage method.
    |
    */
    'keep_original_name' => false,

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    |
    | List of sizes images should be resized to.
    | Key specifies the file name suffix.
    | Value specifies the size value.
    | 
    */
    'sizes' => [
        'tb' => 150,
        'sm' => 300,
        'lg' => 1024,
    ],

    /*
    |--------------------------------------------------------------------------
    | Mime types
    |--------------------------------------------------------------------------
    |
    | List of mime types that should be processed.
    |
    */
    'mime_types' => [
        'image/jpeg',
        'image/png'
    ],

];