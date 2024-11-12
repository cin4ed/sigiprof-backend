<?php

namespace App\Helpers;

class LibroUsuarioRoles
{
    public static function all(): array
    {
        return [
            'ASESOR_PRINCIPAL',
            'AUTOR',
            'AUTOR_PARA_CORRESPONDENCIA',
            'AUTOR_PRINCIPAL',
            'AUTOR_UNICO',
            'AUTOR_DE_CORRESPONDENCIA',
            'CO_AUTOR',
            'CO_COORDINADOR',
            'CO_INVENTOR',
            'COLABORADOR',
            'COMPIADOR',
            'COORDINADOR',
            'DIRECTOR',
            'DIRECTOR_Y_O_ASESOR_PRINCIPAL',
            'EDITOR',
            'ESTUDIANTE_AUTOR_PRINCIPAL',
            'INVENTOR',
            'LIDER',
            'PARTICIPANTE',
            'TECNICO',
            'TRADUCTOR'
        ];
    }
}
