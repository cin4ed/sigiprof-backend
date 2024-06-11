<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

/**
 * @tags Courses
 */
class CoursesController extends Controller
{
    /**
     * Get all courses
     *
     * This endpoint retrieves all courses.
     *
     * @return Course[] A list of courses
     */
    public function index()
    {
        return Course::all();
    }

    /**
     * Create a new course
     *
     * This endpoint creates a new course.
     *
     * @return Course The created course
     */
    public function show(Course $course)
    {
        return $course;
    }

    /**
     * Create a new course
     *
     * This endpoint creates a new course.
     *
     * @return Course The created course
     */
    public function update(Course $course, Request $request)
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

        $course->update($validated);

        return $course;
    }

    /**
     * Delete a course
     *
     * This endpoint deletes a course.
     *
     * @return null
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return response()->json(null, 204);
    }
}
