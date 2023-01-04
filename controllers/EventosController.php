<?php
namespace Controllers;

use Classes\Paginacion;
use Model\Categoria;
use Model\Dia;
use Model\Evento;
use Model\Hora;
use MVC\Router;

class EventosController {

    public static function index( Router $router ) {
        if(!is_admin()) header('Location: /login');

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if (!$pagina_actual || $pagina_actual < 1) header('Location: /admin/eventos?page=1');

        $registros_por_pagina = 10;
        $total = Evento::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);

        if($paginacion->total_paginas() < $pagina_actual) header('Location: /admin/eventos?page=1');

        $eventos = Evento::paginar($registros_por_pagina, $paginacion->offset());

        $router->render('admin/eventos/index', [
            'titulo' => 'Conferencias y Workshops',
            'paginacion' => $paginacion->paginacion()
        ]);
    }

    public static function crear( Router $router ) {
        $alertas = [];
        $evento = new Evento;
        $categorias = Categoria::all('ASC');
        $dias = Dia::all('ASC');
        $horas = Hora::all('ASC');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $evento->sincronizar($_POST);
            $alertas = $evento->validar();
            
            if (empty($alertas)) {

                $resultado = $evento->guardar();
                if ($resultado) {
                    header('Location: /admin/eventos');
                }
            }
        }

        $router->render('admin/eventos/crear', [
            'titulo' => 'Crear Evento',
            'alertas' => $alertas,
            'evento' => $evento,
            'categorias' => $categorias,
            'dias' => $dias,
            'horas' => $horas,
        ]);
    }

    public static function editar( Router $router ) {
        $alertas = [];
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) header('Location: /admin/eventos');

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        }

        $router->render('admin/eventos/editar', [
            'titulo' => 'Actualizar Evento',
            'alertas' => $alertas,
        ]);
    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location: /login');
            }
        }
    }
    
}