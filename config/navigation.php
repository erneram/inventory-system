<?php
return [
    'routes' => [
        // [
        //     'name' => 'Dashboard',
        //     'route' => 'dashboard',
        // ],
        [
            'name' => 'Categorias',
            'route' => 'categories.index',
        ],
        [
            'name' => 'Productos',
            'route' => 'products.index',
        ],
        [
            'name' => 'Movimientos de Inventario',
            'route' => 'inventory-movements.index'
        ],
        [
            'name' => 'Inventario',
            'route' => 'stocks.index'
        ],
        [
            'name' => 'Detalle de ventas',
            'route' => 'sales-details.index'
        ]
    ],
];
