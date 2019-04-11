<?php
    return [
        'shop' => [
            'resources' => [
                'product' => [
                    'views' => [
                        'show' => [
                            'positions' => [
                                'top' => [
                                    'modules' => [],
                                ],
                                'side' => [
                                    'modules' => [],
                                ],
                                'bottom' => [
                                    'modules' => [],
                                ],
                            ],
                        ],
                    ],
                ],
                'category' => [
                    'views' => [
                        'show' => [
                            'positions' => [
                                'top' => [
                                    'modules' => [],
                                ],
                                'side' => [
                                    'modules' => [],
                                ],
                                'bottom' => [
                                    'modules' => [],
                                ],
                            ],
                        ],
                        'list' => [
                            'positions' => [
                                'top' => [
                                    'modules' => [],
                                ],
                                'side' => [
                                    'modules' => [],
                                ],
                                'bottom' => [
                                    'modules' => [],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'home' => [
            'top' => [
                [
                    'folder' => 'banner',
                    'view' => 'default'
                ]
            ],
            'side' => [
                [
                    'folder' => 'menu',
                    'view' => 'vertical'
                ]
            ],
            'bottom' => [
                []
            ],
            'content_top' => [
                []
            ],
            'content_side' => [
                []
            ],
            'content_bottom' => [
                [
                    'folder' => 'offers',
                    'view' => 'default'
                ]
            ],
        ],
    ];