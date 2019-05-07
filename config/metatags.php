<?php
//keys relations, values, tags is necessary;
return [

    'default' => [

        'relations' => [
        ],
        'values' => [
            'siteName' => env('APP_NAME'),
        ],
        'tags' => [
            'title' => env('METATAGS_DEFAULT_TAGS_TITLE'),
            'description' => env('METATAGS_DEFAULT_TAGS_DESCRIPTION'),
            'keywords' => env('METATAGS_DEFAULT_TAGS_KEYWORDS'),

        ]

    ],

    'product' => [

        'relations' => [
            'productScu'        => env('METATAGS_PRODUCT_RELATIONS_PRODUCTSCU'),
            'productName'       => env('METATAGS_PRODUCT_RELATIONS_PRODUCTNAME'),
            'productPrice'      => env('METATAGS_PRODUCT_RELATIONS_PRODUCTPRICE'),
            'categoryName'      => env('METATAGS_PRODUCT_RELATIONS_CATEGORYNAME'),
            'manufacturerName'  => env('METATAGS_PRODUCT_RELATIONS_MANUFACTURERNAME'),
        ],
        'values' => [],
        'tags' => [
            'title' => env('METATAGS_PRODUCT_TAGS_TITLE'),
            'description' => env('METATAGS_PRODUCT_TAGS_DESCRIPTION'),
            'keywords' => env('METATAGS_PRODUCT_TAGS_KEYWORDS'),

        ]

    ],

    'category' => [

        'relations' => [
            'categoryName' => env('METATAGS_CATEGORY_RELATIONS_CATEGORYNAME'),
        ],
        'values' => [],
        'tags' => [
            'title' => env('METATAGS_CATEGORY_TAGS_TITLE'),
            'description' => env('METATAGS_CATEGORY_TAGS_DESCRIPTION'),
            'keywords' => env('METATAGS_CATEGORY_TAGS_KEYWORDS'),

        ]

    ],

    'brand' => [

        'relations' => [
            'brandName' => env('METATAGS_BRAND_RELATIONS_BRANDNAME'),
        ],

        'tags' => [
            'title' => env('METATAGS_BRAND_TAGS_TITLE'),
            'description' => env('METATAGS_BRAND_TAGS_DESCRIPTION'),
            'keywords' => env('METATAGS_BRAND_TAGS_KEYWORDS'),

        ]

    ],

];
