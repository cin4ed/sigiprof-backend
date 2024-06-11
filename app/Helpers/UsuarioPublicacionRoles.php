<?php

namespace App\Helpers;

class UsuarioPublicacionRoles
{
    public static function all(): array
    {
        return [
            'ASESOR_PRINCIPAL',
            'AUTOR',
            'AUTOR_PARA_CORRESPONDENCIA',
            'AUTOR_PRINCIPAL',
            'AUTOR_UNICO',
            'AUTOR_CORRESPONDIENTE',
            'CO_AUTOR',
            'CO_COORDINADOR',
            'CO_DIRECTOR',
            'CO_INVENTOR',
            'COLABORADOR',
            'COMPILADOR',
            'COORDINADOR',
            'DIRECTOR',
            'DIRECTOR_ASESOR_PRINCIPAL',
            'EDITOR',
            'ESTUDIANTE_AUTOR_PRINCIPAL',
            'INVENTOR',
            'LIDER',
            'PARTICIPANTE',
            'TECNICO',
            'TRADUCTOR',
        ];
    }
}
