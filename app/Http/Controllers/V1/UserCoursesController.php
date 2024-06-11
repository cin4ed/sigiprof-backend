<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

/**
 * @tags Courses
 */
class UserCoursesController extends Controller
{
    /**
     * Get all courses for current user
     *
     * This endpoint retrieves all courses that are associated with the
     *
     * @return Course[] A list of courses
     */
    public function index()
    {
        return auth()->user()->courses;
    }

    /**
     * Create a new course for current user
     *
     * This endpoint creates a new course for the authenticated user.
     *
     * @return Course The created course
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo_formacion' => 'required|in:ACREDITACION,CERTIFICACION,COACHING,CURSO,DIPLOMADO,SEMIMARIO,TALLER',
            'nombre' => 'required|string',
            'anio' => 'required|integer',
            'horas_totales' => 'required|integer',
            'institucion' => 'required|string',
            'tipo_institucion' => 'required|in:EXTRANJERA,NACIONAL',
            'modalidad_institucion' => 'required|in:PUBLICA_FEDERAL,PUBLICA_ESTATAL,PUBLICA_MUNICIPAL,PRIVADA',
            'descripcion' => 'required|string',
        ]);

        $course = auth()->user()->courses()->create($validated);

        return $course;
    }
}
