<?php

namespace App\Helpers;

class LibroUsuarioRoles
{
    public static function all(): array
    {
        return [
            'AUTOR',
            'COAUTOR',
            'AYUDANTE',
            'ENCARGADO',
            'SUPERVISADO',
            'EDITOR',
            'REVISOR',
            'COLABORADOR',
            'ASESOR',
            'INVESTIGADOR_PRINCIPAL',
            'COORDINADOR',
            'DIRECTOR',
        ];
    }
}
