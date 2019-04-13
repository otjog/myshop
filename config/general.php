<?php

    return [

        'template_name' => env('SITE_TEMPLATE'),
        'site_url' => env('APP_URL'),
        'today' => date('Y-m-d'),
        'info' => [
            'email' => env('SITE_EMAIL'),
            'phone' => env('SITE_PHONE'),
            'address' => env('SITE_ADDRESS'),
        ],
        'general' => [
            'images' => [
                'path' => 'storage/img/',
                'const_ext' => 2 //сохранять миниатюры в jpeg
            ]
        ],
        'images' => [
            'models' => [
                'banner' => [
                    'size' => [
                        'main' => '1110x400'
                    ],
                    'original_folder' => '', //со слешем, ex.: original/
                    'path_to_default_image'  => public_path('storage/img/banners/default/no-image.jpg'),
                    'path_to_image_folder' => public_path('storage/img/banners/'),
                    'change' => 'fit', //обрезать изо до заданного ихображения
                ],
                'product' => [
                    'size' => [
                        'xxs'   => '55x55',
                        'xs'    => '130x130',
                        's'     => '370x370',
                        'm'     => '450x450',
                        'm-13'  => '450x600', //W*1 x H*1.3
                        'l'     => '1000x1000',
                    ],
                    'original_folder' => '', //со слешем, ex.: original/
                    'path_to_default_image'  => public_path('storage/img/shop/product/default/no-image.jpg'),
                    'path_to_image_folder' => public_path('storage/img/shop/product/'),
                    'change' => 'resize', //пропорционально уменьшать и добавлять белые поля
                ],
            ],
        ],
        'components' => [
            'shop' => [
                'currency' => '',
                'price' => '',
                'pagination' => 15,
                'chunk_products' => 3,
                'chunk_categories' => 4,
                'filter_prefix' => 'p_',
            ]
        ],
    ];