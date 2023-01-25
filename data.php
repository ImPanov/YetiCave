<?php
$categories = [
    'boards' => 'Доски и лыжи',
    'attachment' => 'Крепление',
    'boots' => 'Ботински',
    'clothes' => 'Одежда',    
    'tools' => 'Инструменты',
    'other' => 'Разное',
];

$goods = [
    [
        'title' => '2014 Rossignol District Snowboard',
        'category' => $categories['boards'],
        'price' => 10999,
        'image' => 'img/lot-1.jpg',
        'expiration' => "2023-02-26",
    ],
    [
        'title' => 'DC Ply Mens 2016/2017 Snowboard',
        'category' => $categories['boards'],
        'price' => 15999,
        'image' => 'img/lot-2.jpg',
        'expiration' => "2023-02-09",
    ],
    [
        'title' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => $categories['attachment'],
        'price' => 8000,
        'image' => 'img/lot-3.jpg',
        'expiration' => "2023-02-15",
    ],
    [
        'title' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => $categories['boots'],
        'price' => 10999,
        'image' => 'img/lot-4.jpg',
        'expiration' => "2023-02-04",
    ],
    [
        'title' => 'Куртка для сноуборда DC Mutiny Charocal',
        'category' => $categories['clothes'],
        'price' =>7500,
        'image' => 'img/lot-5.jpg',
        'expiration' => "2023-02-22",
    ],
    [
        'title' => 'Маска Oakley Canopy',
        'category' => $categories['other'],
        'price' => 5400,
        'image' => 'img/lot-6.jpg',
        'expiration' => "2023-02-11",
    ]
    ];
$is_auth = rand(0, 1);

$user_name = 'Илья'; // укажите здесь ваше имя