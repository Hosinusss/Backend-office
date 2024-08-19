<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/api/user' => [[['_route' => 'api_user', '_controller' => 'App\\Controller\\ApiController::getAuthenticatedUser'], null, ['GET' => 0], null, false, false, null]],
        '/authentification' => [[['_route' => 'app_authentification', '_controller' => 'App\\Controller\\AuthentificationController::index'], null, null, null, false, false, null]],
        '/api/products' => [
            [['_route' => 'add_product', '_controller' => 'App\\Controller\\ProductController::addProduct'], null, ['POST' => 0], null, false, false, null],
            [['_route' => 'addproduct', '_controller' => 'App\\Controller\\ProductController::addProduct'], null, null, null, false, false, null],
        ],
        '/api/login_check' => [[['_route' => 'api_login_check'], null, null, null, false, false, null]],
        '/signup' => [[['_route' => 'signup', '_controller' => 'App\\Controller\\SignupController::signup'], null, null, null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        35 => [
            [['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
