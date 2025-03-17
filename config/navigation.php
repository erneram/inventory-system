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
            'name' => 'Movimientos de inventario',
            'route' => 'inventory-movements.index'
        ],
        [
            'name' => 'Inventario',
            'route' => 'stocks.index'
        ],
        [
            'name' => 'Ventas',
            'route' => 'sales.index'
        ],
        [
            'name' => 'Detalle de ventas',
            'route' => 'sales-details.index'
        ]
    ],
];
