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
            'title' => 'Пальто и платья - купить, цена, инструкция и фото в интернет-магазине {{siteName}}',
            'description' => 'Пальто и платья - купить в Москве, Белгороде и России: цена, инструкция по эксплуатации и характеристики в интернет-магазине {{siteName}}. Доставка в любой регион России, гарантия - 12 мес.',
            'keywords' => 'Пальто, платья, купальники купить, пальто цвета, платья отзывы, нижнее белье купить, куртки купить',

        ]

    ],

    'product' => [

        'relations' => [
            'productScu'        => 'scu',
            'productName'       => 'name',
            'productPrice'      => 'price|value',
            'categoryName'      => 'category|name',
            'manufacturerName'  => 'manufacturer|name',
        ],
        'values' => [],
        'tags' => [
            'title' => '{{productName}} {{manufacturerName}} - купить, цена, инструкция и фото в интернет-магазине {{siteName}}',
            'description' => '{{productName}} {{manufacturerName}} - купить в Москве, Белгороде и России: цена, инструкция по эксплуатации и характеристики в интернет-магазине {{siteName}}. Доставка в любой регион России, гарантия - 12 мес.',
            'keywords' => '{{productName}} {{manufacturerName}}, {{categoryName}}, {{productName}} купить, {{productName}} характеристики, {{productName}} отзывы, {{manufacturerName}} купить, {{categoryName}} купить',

        ]

    ],

    'category' => [

        'relations' => [
            'categoryName'      => 'name',
        ],
        'values' => [],
        'tags' => [
            'title' => '{{categoryName}} для дома, коттеджа и дачи, купить {{categoryName}} в Белгороде, Москве, СПб и РФ - цены, отзывы, видео, фото и характеристики в интернет-магазине {{siteName}}',
            'description' => 'Купить {{categoryName}} для коттеджа, дома и дачи в Белгороде, Москве и РФ - цены, отзывы, видео, фото и характеристики в интернет-магазине {{siteName}}. В продаже имеются {{categoryName}} всех типов по лучшей цене. Гарантия, доставка во все регионы.',
            'keywords' => '{{categoryName}},  {{categoryName}} цены характеристики, {{categoryName}} отзывы, {{categoryName}} купить, {{categoryName}} цена, {{categoryName}} цены характеристики отзывы',

        ]

    ],

    'brand' => [

        'relations' => [
            'brandName'      => 'name',
        ],

        'tags' => [
            'title' => '{{brandName}} для дома, коттеджа и дачи, купить {{brandName}} в Белгороде, Москве, СПб и РФ - цены, отзывы, видео, фото и характеристики в интернет-магазине {{siteName}}',
            'description' => 'Купить {{brandName}} для коттеджа, дома и дачи в Белгороде, Москве и РФ - цены, отзывы, видео, фото и характеристики в интернет-магазине {{siteName}}. В продаже имеются {{categoryName}} всех типов по лучшей цене. Гарантия, доставка во все регионы.',
            'keywords' => '{{brandName}},  {{brandName}} цены характеристики, {{brandName}} отзывы, {{brandName}} купить, {{brandName}} цена, {{brandName}} цены характеристики отзывы',

        ]

    ],

];
