<form action="/assignment/newTeacherCourse" method="POST">
    @csrf
    <input type="hidden" name="teachers_id" value="{{ $user->id }}">


    <div>
        <label for="course_id">Seleccione una Sección:</label>
        <select name="course_id">
            @foreach($courses as $course)
                <option value="{{ $course->id }}">{{ $course->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="section_id">Seleccione una Sección:</label>
        <select name="section_id">
            @foreach($sections as $section)
                <option value="{{ $section->id }}">{{ $section->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="degree_id">Seleccione un Grado:</label>
        <select name="degree_id">
            @foreach($degrees as $grade)
                <option value="{{ $grade->id }}">{{ $grade->name }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        Asignar Cursos
    </button>
</form>
