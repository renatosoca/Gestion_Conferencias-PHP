<?php
namespace App\Controllers;

use App\Router;

class RegalosController {

    public static function index( Router $router ) {

        $router->render('admin/regalos/index', [
            'titulo' => 'Regalos'
        ]);
    }
}