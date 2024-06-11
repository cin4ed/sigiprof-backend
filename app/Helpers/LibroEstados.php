<?php

namespace App\Helpers;

class LibroEstados
{
    public static function all(): array
    {
        return [
            'PLANEACION',
            'EN_PROGRESO',
            'REVISION',
            'COMPLETADO',
            'ATRASADO',
            'CANCELADO',
            'PAUSADO',
            'ENTREGADO',
            'EN_ESPERA_DE_APROBACION',
            'APROBADO',
            'RECHAZADO',
        ];
    }
}
