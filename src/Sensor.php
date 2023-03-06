<?php
namespace App;

use App\Interfaces\Observable;
use App\Interfaces\Observador;

// Implementa la Interfaz Observable lo que le permite
// notificar a los objetos Observadores cada vez que
// se actualiza su estado.
class Sensor implements Observable
{
    const CALMA = 1;
    const TORMENTA = 2;
    const ESTADOS = ["CALMA" => self::CALMA, "TORMENTA" => self::TORMENTA];
    
    private $observadores = [];
    private $estado = self::CALMA;

    // De acuerdo con la interfaz Observable, implementa un
    // método que le permite registrar nuevos observadores.
    public function registrarObservador(Observador $o)
    {
        $this->observadores[] = $o;
    }

    // De acuerdo con la interfaz Observable, implementa un
    // método que le permite eliminar observadores.
    public function eliminarObservador(Observador $o)
    {
        foreach ($this->observadores as $key => $observador) {
            if ($observador === $o) {
                array_splice($this->observadores,$key,1);
                echo "Observador removido.".PHP_EOL;
                return;
            }
        }
    }

    // De acuerdo con la interfaz Observable, implementa un
    // método que le permite notificar a los observadores.
    public function notificarObservadores()
    {
        foreach ($this->observadores as $observador) {
            $observador->actualizar($this->estado);
        }
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function getNumeroObservadores()
    {
        return count($this->observadores);
    }

    public function getObservadores()
    {
        return $this->observadores;
    }

    public function getTextoEstado()
    {
        return array_keys(self::ESTADOS)[$this->estado - 1];
    }
}