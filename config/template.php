<?php
    return [
        'header' => [
            'top' => [
                [
                    'module' => 'site.header.top_line',
                    'template' => 'default'
                ],
                [
                    'module' => 'site.header.main_line',
                    'template' => 'default'
                ],
                [
                    'module' => 'menu',
                    'template' => 'navbar',
                    'attach' => [
                        'menu_alias' => 'top_menu'
                    ]

                ]

            ],
        ],
        'content' => [
            'shop' => [
                'product' => [
                    'show' => [
                        'top' => [],
                        'side' => [],
                        'bottom' => [],
                    ],
                ],
                'category' => [
                    'show' => [
                        'top' => [],
                        'side' => [],
                        'bottom' => [],
                    ],
                    'list' => [
                        'top' => [],
                        'side' => [],
                        'bottom' => [],
                    ],
                ],
                'brand' => [
                    'show' => [
                        'top' => [],
                        'side' => [],
                        'bottom' => [],
                    ],
                    'list' => [
                        'top' => [],
                        'side' => [],
                        'bottom' => [],
                    ],
                ],
                'search' => [
                    'show' => [
                        'top' => [],
                        'side' => [],
                        'bottom' => [ ],
                    ],
                ],
                'basket' => [
                    'edit' => [
                        'top' => [],
                        'side' => [],
                        'bottom' => [],
                    ],
                ],
                'order' => [
                    'show' => [
                        'top' => [],
                        'side' => [],
                        'bottom' => [],
                    ],
                ],
            ],
            'info' => [
                'page' => [
                    'show' => [
                        'top' => [],
                        'side' => [],
                        'bottom' => [],
                    ],
                    'list' => [
                        'top' => [],
                        'side' => [],
                        'bottom' => [],
                    ],
                    'edit' => [
                        'top' => [],
                        'side' => [],
                        'bottom' => [],
                    ],
                ],
            ],
            'home' => [
                'top' => [
                    [
                        'module' => 'banner',
                        'template' => 'main'
                    ]
                ],
                'side' => [
                    [
                        'module' => 'menu',
                        'template' => 'vertical',
                        'attach' => [
                            'menu_alias' => 'vertical'
                        ]
                    ],
                    [
                        'module' => 'offers',
                        'template' => 'vertical',
                        'attach' => [
                            'offer_alias' => 'sale'
                        ]
                    ],

                ],
                'bottom' => [],
                'content_top' => [],
                'content_side' => [],
                'content_bottom' => [
                    [
                        'module' => 'offers',
                        'template' => 'horizontal',
                        'attach' => [
                            'offer_alias' => 'newest'
                        ]
                    ],
                    [
                        'module' => 'offers',
                        'template' => 'horizontal',
                        'attach' => [
                            'offer_alias' => 'sale'
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
                        'menu_alias' => 'footer_menu_about'
                    ]
                ],
                [
                    'module' => 'menu',
                    'template' => 'footer',
                    'attach' => [
                        'menu_alias' => 'footer_menu_shop'
                    ]
                ],
                [
                    'module' => 'menu',
                    'template' => 'footer',
                    'attach' => [
                        'menu_alias' => 'footer_menu_services'
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