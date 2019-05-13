<?php
    return [
        'header' => [
            'top' => [
                [
                    'module' => 'site.header.main_line',
                    'template' => 'default'
                ],
                [
                    'module' => 'menu',
                    'template' => 'navbar',
                    'attach' => [
                        'menu_name' => 'top_menu'
                    ]

                ]

            ],
        ],
        'content' => [
            'home' => [
                'top' => [
                    [
                        'module' => 'banner',
                        'template' => 'main'
                    ]
                ],
                'side' => [
                    [
                        'module' => 'offers',
                        'template' => 'vertical',
                        'attach' => [
                            'offer_name' => 'newest'
                        ]
                    ],

                ],
                'content_bottom' => [
                    [
                        'module' => 'menu',
                        'template' => 'icons',
                        'attach' => [
                            'menu_name' => 'icons'
                        ]
                    ],
                    [
                        'module' => 'offers',
                        'template' => 'horizontal',
                        'attach' => [
                            'offer_name' => 'newest'
                        ]
                    ],
                    [
                        'module' => 'offers',
                        'template' => 'horizontal',
                        'attach' => [
                            'offer_name' => 'sale'
                        ]
                    ],

                ],
            ],
        ],
        'footer' => [
            'top' => [
                [
                    'module' => 'menu',
                    'template' => 'footer',
                    'attach' => [
                        'menu_name' => 'footer_menu_about'
                    ]
                ],
                [
                    'module' => 'menu',
                    'template' => 'footer',
                    'attach' => [
                        'menu_name' => 'footer_menu_shop'
                    ]
                ],
                [
                    'module' => 'menu',
                    'template' => 'footer',
                    'attach' => [
                        'menu_name' => 'footer_menu_services'
                    ]
                ],
                [
                    'module' => 'site.footer.social',
                    'template' => 'default',
                ],
                [
                    'module' => 'site.footer.contact',
                    'template' => 'default',
                ],
            ],
            'bottom' => [
                [
                    'module' => 'site.footer.bottom_line',
                    'template' => 'default'
                ],
            ],
        ]
    ];