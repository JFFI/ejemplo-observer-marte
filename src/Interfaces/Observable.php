<?php
namespace App\Interfaces;

use App\Interfaces\Observador;

interface Observable
{
    function registrarObservador(Observador $o);

    function eliminarObservador(Observador $o);

    function notificarObservadores();
}