<?php
namespace App;

use App\Interfaces\Observable;
use App\Interfaces\Observador;

// Implementa la Interfaz Observador lo que le permite
// suscribirse al objeto Observable.
class NaveEspacial implements Observador
{
    const ATERRIZAR_OK = 1;
    const ATERRIZAR_NO = 2;
    private $clima = self::ATERRIZAR_OK;
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
            case self::ATERRIZAR_OK:
                echo "Nave puede aterrizar.";
                break;
            case self::ATERRIZAR_NO:
                echo "Nava no puede aterrizar.";
                break;
            default:
        }
        echo PHP_EOL;
    }
}