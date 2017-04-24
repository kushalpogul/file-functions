<?php
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\Router;

Router::plugin(
    'FileFunctions',
    ['path' => '/file-functions'],
    function ($routes) {
        $routes->fallbacks(DashedRoute::class);
    }
);

?>