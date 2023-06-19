<?php
namespace App\Controllers;

use App\Models\Regalo;
use App\Models\Registro;


class APIRegalos {

    public static function regalos() {
        if(!is_admin()) {
            echo json_encode([]);
            return;
        }

        $regalos = Regalo::all();

        foreach ($regalos as $regalo ) {
            $regalo->total = Registro::whereArray(['regalo_id' => $regalo->id, 'paquete_id' => '1']);
        }

        echo json_encode($regalos);
    }
}