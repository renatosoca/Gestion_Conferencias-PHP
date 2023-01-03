<?php
namespace Controllers;

use MVC\Router;
use Model\Ponente;
use Intervention\Image\ImageManagerStatic as Image;

class PonentesController {

    public static function index( Router $router ) {
        $ponentes = Ponente::all();

        $router->render('admin/ponentes/index', [
            'titulo' => 'Ponentes',
            'ponentes' => $ponentes
        ]);
    }

    public static function crear( Router $router ) {
        $alertas = [];
        $ponente = new Ponente;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!empty($_FILES['imagen']['tmp_name'])) {
                $carpeta_imagenes = '../public/img/speakers';

                if (!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png', 80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp', 80);

                $nombre_imagen = md5( uniqid( rand(), true) );

                $_POST['imagen'] = $nombre_imagen;
            }

            $_POST['redes'] = json_encode( $_POST['redes'], JSON_UNESCAPED_SLASHES );
            $ponente->sincronizar($_POST);
            $alertas = $ponente->validar();
            //guardar Registro
            if (empty($alertas)) {
                //Guardar la imagen
                $imagen_png->save($carpeta_imagenes. '/'.$nombre_imagen . ".png");
                $imagen_webp->save($carpeta_imagenes. '/'.$nombre_imagen . ".webp");
                
                $resultado = $ponente->guardar();
                
                if ($resultado) {
                    header('Location: /admin/ponentes');
                }
            }
        }

        

        $router->render('admin/ponentes/crear', [
            'titulo' => 'Ponentes',
            'alertas' => $alertas,
            'ponente' => $ponente
        ]);
    }

    public static function editar( Router $router ) {
        $alertas = [];
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) header('Location: /admin/ponentes');

        $ponente = Ponente::find($id);

        if (!$ponente) header('Location: /admin/ponente');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ponente->sincronizar();
        }

        $ponente->imagen_actual = $ponente->imagen;

        $router->render('admin/ponentes/editar', [
            'titulo' => 'Actualizar Ponente',
            'alertas' => $alertas,
            'ponente' => $ponente
        ]);
    }
}