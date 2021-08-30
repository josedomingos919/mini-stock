<?php

$_SESSION['active_routes'] =  1;

$_SESSION['routes'] = [ 
    1=>[
        'id'   => 1,
        'icon' => "fas fa-shopping-basket",
        'text' => 'Venda',
        'link' => '/pages/venda/vender'
    ],
    2=>[
        'id'   => 2,
        'icon' => "fab fa-buffer",
        'text' => 'Geral',
        'link' => '/pages/geral/produto'
    ],
    3=>[
        'id'   => 3,
        'icon' => "far fa-calendar-check",
        'text' => 'Apuramento',
        'link' => '/pages/apuramento'
    ], 
];
