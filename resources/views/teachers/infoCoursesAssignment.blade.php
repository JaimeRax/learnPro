<div>
    @php
        // Obtener el docente con sus cursos, secciones y grados
        $teacher = App\Models\User::with(['courses', 'courses.sections', 'courses.degrees'])->find($teacherId);
    @endphp

    @if ($teacher && $teacher->courses->count() > 0)
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr>
                    <th class="py-2">Curso</th>
                    <th class="py-2">Sección</th>
                    <th class="py-2">Grado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teacher->courses as $course)
        <tr>
            <td class="py-2">{{ $course->name }}</td>
            <td class="py-2">{{ optional($course->sections->where('id', $course->pivot->section_id)->first())->name }}</td>
            <td class="py-2">{{ optional($course->degrees->where('id', $course->pivot->degrees_id)->first())->name }}</td>
        </tr>
    @endforeach
            </tbody>
        </table>
    @else
        <p>No hay cursos asignados para este docente.</p>
    @endif
</div>
