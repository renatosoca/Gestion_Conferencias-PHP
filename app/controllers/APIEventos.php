<?php
namespace App\Controllers;

use App\Models\EventoHorario;


class APIEventos {

    public static function index() {
        $dia = $_GET['dia_id'] ?? '';
        $categoria = $_GET['categoria_id'] ?? '';

        $dia = filter_var($dia, FILTER_VALIDATE_INT);
        $categoria = filter_var($categoria, FILTER_VALIDATE_INT);

        if (!$dia || !$categoria) echo json_encode([]);

        $eventos = EventoHorario::whereArray(['dia_id' => $dia, 'categoria_id' => $categoria]);
        
        echo json_encode($eventos);
    }
}