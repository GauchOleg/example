<?php

return [
    '/' => 'site/index',
    'category/<id:\d+>' => 'category/index/',
    'producer/<id:\d+>' => 'site/producer/',
    'sort-category' => 'category/sort-category',
    'dashboard' => 'dashboard/backend/index',
    'dashboard/category' => 'dashboard/category/index',
    'dashboard/product' => 'dashboard/product/index',
];