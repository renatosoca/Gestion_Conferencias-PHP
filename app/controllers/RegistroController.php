<?php

namespace App\Controllers;

use App\Router;
use App\Models\Dia;
use App\Models\Hora;
use App\Models\Evento;
use App\Models\Regalo;
use App\Models\Paquete;
use App\Models\Ponente;
use App\Models\Usuario;
use App\Models\Registro;
use App\Models\Categoria;
use App\Models\DetalleRegistro;

class RegistroController {

    public static function crear( Router $router ) {
        if (!is_auth()) header('Location: /');

        //Verificar si ya tiene una compra
        $registro = Registro::where('usuario_id', $_SESSION['id']);
        if (isset($registro) && ($registro->paquete_id === '3' || $registro->paquete_id === '2')) header('Location: /boleto?id='. urlencode($registro->token));

        if (isset($registro) && $registro->paquete_id === '1') header('Location: /finalizar-registro/conferencias');
        
        $router->render('registro/crear', [
            'titulo' => 'Registro de Evento'
        ]);
    }

    public static function gratis( Router $router ) {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_auth()) header('Location: /login');

            //Virificar si ya tiene una compra
            $registro = Registro::where('usuario_id', $_SESSION['id']);
            if (isset($registro) && $registro->paquete_id === '3') header('Location: /boleto?id='. urlencode($registro->token));

            $token = substr( md5( uniqid( rand(), true) ), 0, 8);

            //Crear Registro
            $datos = [
                'paquete_id' => 3,
                'pago_id' => '',
                'token' => $token,
                'usuario_id' => $_SESSION['id']
            ];

            $registro = new Registro($datos);
            $resultado = $registro->guardar();
            if ($resultado) header('Location: /boleto?id='. urlencode($registro->token));
        }
    }

    public static function pagar( Router $router ) {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_auth()) header('Location: /login');
            
            //Validar que POST no venga vacio
            if ( empty($_POST)){
                echo json_encode([]);
                return;
            }

            //Crear el registro
            $datos = $_POST;
            $datos['token'] = substr( md5( uniqid( rand(), true) ), 0, 8);
            $datos['usuario_id'] = $_SESSION['id'];

            try {
                $registro = new Registro($datos);
                $resultado = $registro->guardar();
                echo json_encode($resultado);
            } catch (\Throwable $th) {
                echo json_encode([
                    'resultado' => 'error'
                ]);
            }
        }
    }

    public static function boleto( Router $router ) {
        $id= s($_GET['id']);
        if (!$id || !strlen($id) === '8') header('Location: /'); 

        $registro = Registro::where('token', $id);
        if (!$registro) header('Location: /');

        $registro->usuario = Usuario::find($registro->usuario_id);
        $registro->paquete = Paquete::find($registro->paquete_id);

        $router->render('registro/boleto', [
            'titulo' => 'Boleto Virtual',
            'registro' => $registro
        ]);
    }

    public static function conferencias( Router $router ) {
        if (!is_auth()) header('Location: /login');
         
        $registro = Registro::where('usuario_id', $_SESSION['id']);
        if (isset($registro) && $registro->paquete_id === '2') header('Location: /boleto?id='. urlencode($registro->token));

        if ($registro->paquete_id !== '1') header('Location: /');

        if ($registro->regalo_id === '1' && $registro->paquete_id === '1') { 
            header('Location: /finalizar-registro/conferencia');
        } else {
            header('Location: /boleto?id='. urlencode($registro->token));
        }
        $eventos = Evento::ordenar('hora_id', 'ASC');
        $regalos = Regalo::all('ASC');

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

            $ponentes = Ponente::all();
            $ponentes_total = Ponente::total();
            $conferencias = Evento::total('categoria_id', 1);
            $workshops = Evento::total('categoria_id', 2);
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_auth()) header('Location: /login');

            $eventos = explode(',', $_POST['eventos']);
            if (empty($eventos)) {
                echo json_encode(['respuesta' => false]);
                return;
            }
            //Obtener Registrol Usuario
            $registro = Registro::where('usuario_id', $_SESSION['id']);
            if (!isset($registro) || $registro->paquete_id !== '1') {
                echo json_encode(['respuesta' => false]);
                return;
            }

            //Validar la disponibilidad de los eventows registrado
            $eventos_array = [];
            foreach ($eventos as $evento_id) {
                $evento = Evento::find($evento_id);
                
                if (!isset($evento) || $evento->disponibles === '0') {
                    echo json_encode(['respuesta' => false]);
                    return;
                }

                $eventos_array[] = $evento;
            }

            //
            foreach ($eventos_array as $evento) {
                $evento->disponibles -= 1;
                $evento->guardar();

                //Almacenar el registro
                $datos = [
                    'evento_id' => (int) $evento->id,
                    'registro_id' => (int) $registro->id
                ];

                $registro_evento = new DetalleRegistro($datos);
                $registro_evento->guardar();
            }

            //Almacenar el regalo
            $registro->sincronizar(['regalo_id' => $_POST['regalo_id']]);
            $resultado = $registro->guardar();
            if ($resultado) {
                echo json_encode([
                    'respuesta' => $resultado,
                    'token' => $registro->token
                ]);
            } else {
                echo json_encode(['respuesta' => false]);
            }
            return;
        }

        $router->render('registro/conferencias', [
            'titulo' => 'Escoge tu Evento',
            'eventos' => $eventos_formateador,
            'regalos' => $regalos
        ]);
    }
}