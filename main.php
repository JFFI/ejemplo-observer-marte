<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\DronGeomatico;
use App\NaveEspacial;
use App\RobotMeteorologico;
use App\Sensor;

const NOTIFICAR = 1;
const AGREGAR = 2;
const REMOVER = 3;
const SALIR = 0;

$sensor = new Sensor();

$salir = false;
while(!$salir) {
    echo "******* ******* ******* ******* *******". PHP_EOL;
    echo "Número de observadores: " . $sensor->getNumeroObservadores() . PHP_EOL;
    echo "Estado actual: " . $sensor->getTextoEstado() . PHP_EOL;
    echo PHP_EOL;
    indicarAcciones();
    $accion = readline("Ingrese un número:");
    switch ($accion) {
        case NOTIFICAR:
            notificar($sensor);
            break;
        case AGREGAR:
            agregar($sensor);
        break;
        case REMOVER:
            remover($sensor);
            break;
        case SALIR:
            $salir = true;
            break;
        default:
            echo "No se reconoce el número.". PHP_EOL;
            break;
    }
    if (!$salir) {
        echo PHP_EOL;
        readline("Presione enter para continuar");
        echo PHP_EOL;
    }
}
echo "Saliendo...". PHP_EOL;

function indicarAcciones()
{
    echo "Ingrese uno de los siguientes números:" . PHP_EOL;
    echo " -> ".NOTIFICAR.": Notificar observadores". PHP_EOL;
    echo " -> ".AGREGAR.": Agregar observador". PHP_EOL;
    echo " -> ".REMOVER.": Remover observador". PHP_EOL;
    echo " -> ".SALIR.": Salir". PHP_EOL;
    echo PHP_EOL;
}

function notificar(&$sensor)
{
    echo PHP_EOL;
    echo "Seleccione uno de los siguientes números:" . PHP_EOL;
    echo "Estados a notificar:" . PHP_EOL;
    foreach(Sensor::ESTADOS as $key => $estado) {
        echo " -> " .$estado. ": " . $key . PHP_EOL;
    }
    echo PHP_EOL;
    $estadoNotificar = readline("Ingrese un número:");
    $sensor->setEstado($estadoNotificar);
    echo PHP_EOL;
    echo "Enviando notificación: ". $sensor->getTextoEstado() . PHP_EOL. PHP_EOL;
    $sensor->notificarObservadores();
}

function agregar(&$sensor)
{
    
    echo PHP_EOL;
    echo "Seleccione uno de los siguientes números:" . PHP_EOL;
    echo "Observador a agregar:" . PHP_EOL;
    echo " -> 1: Dron Geomático" . PHP_EOL;
    echo " -> 2: Robot Meteorológico" . PHP_EOL;
    echo " -> 3: Nave Espacial" . PHP_EOL;
    echo PHP_EOL;
    $tipoObservador = readline("Ingrese un número:");
    try {
        $observadorAgregar = instanciarObservador($tipoObservador);
        $observadorAgregar->setObservable($sensor);
        $sensor->registrarObservador($observadorAgregar);
        $sensor->notificarObservadores();
    } catch (\Throwable $th) {
        echo $th->getMessage(). PHP_EOL;
    }
}

function remover(&$sensor)
{
    echo PHP_EOL;
    if ($sensor->getNumeroObservadores() <= 0) {
        echo "No hay observadores." . PHP_EOL;
        return;
    }
    echo "Seleccione el observador a remover:" . PHP_EOL;
    $observadores = $sensor->getObservadores();
    foreach($observadores as $key => $observador) {
        echo " -> ".($key). ": " . get_class($observador) . PHP_EOL;
    }
    $numeroObservador = readline("Ingrese un número:");
    if (isset($observadores[$numeroObservador])) {
        $observadores[$numeroObservador]->desuscribirse();
    } else {
        echo "No existe el observador.".PHP_EOL;
    }
}

function instanciarObservador($numero)
{
    switch ($numero) {
        case 1:
            return new DronGeomatico();
        case 2:
            return new RobotMeteorologico();
        case 3:
            return new NaveEspacial();
        default:
            throw new \Exception("No se reconoce el número.", 1);
    }
}