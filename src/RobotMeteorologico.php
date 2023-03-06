<?php
namespace App;

use App\Interfaces\Observable;
use App\Interfaces\Observador;

// Implementa la Interfaz Observador lo que le permite
// suscribirse al objeto Observable.
class RobotMeteorologico implements Observador
{
    const ESPERA = 1;
    const TOMA_DATOS = 2;
    private $clima = self::ESPERA;
    private $observable;

    // De acuerdo con la interfaz Observador, implementa un
    // método que le permite recibir la actualización del
    // estado del objeto Observable.
    public function actualizar($datos)
    {
        $this->clima = $datos;
        $this->realizarAccion();
    }

    public function setObservable(Observable $observable)
    {
        $this->observable = $observable;
    }

    public function desuscribirse()
    {
        if (isset($this->observable)) {
            $this->observable->eliminarObservador($this);
        }
    }

    private function realizarAccion()
    {
        echo PHP_EOL;
        switch ($this->clima) {
            case self::ESPERA:
                echo "Robot en espera.";
                break;
            case self::TOMA_DATOS:
                echo "Robot tomando datos.";
                break;
            default:
        }
        echo PHP_EOL;
    }
}