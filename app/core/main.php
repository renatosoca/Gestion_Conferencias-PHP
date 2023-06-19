<?php 

use Dotenv\Dotenv;
use App\Models\ActiveRecord;

require __DIR__.'/../../includes/funciones.php';
require __DIR__.'/../../database/Connection.php';
require __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__.'/../../');
$dotenv->safeLoad();

$connectionDB = new connection();
$connectionDB = $connectionDB->connect();

ActiveRecord::setDB($connectionDB);