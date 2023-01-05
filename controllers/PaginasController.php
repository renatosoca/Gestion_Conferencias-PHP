<?php
namespace Controllers;

use Model\Dia;
use Model\Hora;
use MVC\Router;
use Model\Evento;
use Model\Ponente;
use Model\Categoria;

class PaginasController {

    public static function index( Router $router ) {
        $eventos = Evento::ordenar('hora_id', 'ASC');

        $eventos_formateador = [];
        foreach ($eventos as $evento) {
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->hora = Hora::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);

            if ($evento->dia_id === '1' && $evento->categoria_id === '1') {
                $eventos_formateador['conferencias_l'][] = $evento;
            }
            if ($evento->dia_id === '1' && $evento->categoria_id === '2') {
                $eventos_formateador['workshops_l'][] = $evento;
            }
            if ($evento->dia_id === '2' && $evento->categoria_id === '1') {
                $eventos_formateador['conferencias_m'][] = $evento;
            }
            if ($evento->dia_id === '2' && $evento->categoria_id === '2') {
                $eventos_formateador['workshops_m'][] = $evento;
            }
        }

        $router->render('paginas/index', [
            'titulo' => 'Inicio',
            'eventos' => $eventos_formateador
        ]);
    }

    public static function eventos( Router $router ) {

        $router->render('paginas/eventos', [
            'titulo' => 'Sobre DevWebCamp'
        ]);
    }

    public static function paquetes( Router $router ) {

        $router->render('paginas/paquetes', [
            'titulo' => 'Paquetes'
        ]);
    }

    public static function conferencias( Router $router ) {

        $eventos = Evento::ordenar('hora_id', 'ASC');

        $eventos_formateador = [];
        foreach ($eventos as $evento) {
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->hora = Hora::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);

            if ($evento->dia_id === '1' && $evento->categoria_id === '1') {
                $eventos_formateador['conferencias_l'][] = $evento;
            }
            if ($evento->dia_id === '1' && $evento->categoria_id === '2') {
                $eventos_formateador['workshops_l'][] = $evento;
            }
            if ($evento->dia_id === '2' && $evento->categoria_id === '1') {
                $eventos_formateador['conferencias_m'][] = $evento;
            }
            if ($evento->dia_id === '2' && $evento->categoria_id === '2') {
                $eventos_formateador['workshops_m'][] = $evento;
            }
        }

        $router->render('paginas/conferencias', [
            'titulo' => 'Conferencias & Workshops',
            'eventos' => $eventos_formateador
        ]);
    }
}
