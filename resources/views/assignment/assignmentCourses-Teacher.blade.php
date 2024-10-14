<meta name="csrf-token" content="{{ csrf_token() }}">

<form id="add-selection-form">
    @csrf
    <input type="hidden" id="teachers_id" value="{{ $user->id }}">

    <x-inputs.select-option id="section_id" titulo="Sección" name="section_id" :options="$sections->pluck('name', 'id')->toArray()" required />
    <x-inputs.select-option id="degree_id" titulo="Grado" name="degree_id" :options="$degrees->pluck('name', 'id')->toArray()" required />
    <x-inputs.select-option id="course_id" titulo="Curso" name="course_id" :options="$courses->pluck('name', 'id')->toArray()" required />

    <button type="button" id="add-selection" class="w-full text-white bg-green-700 hover:bg-green-800">
        Agregar Selección
    </button>
</form>

<!-- Tabla para visualizar selecciones -->
<table id="selections-table" class="w-full text-sm text-left text-gray-500">
    <thead>
        <tr>
            <th>Sección</th>
            <th>Grado</th>
            <th>Curso</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <!-- Las selecciones aparecerán aquí -->
    </tbody>
</table>

<!-- Botón para guardar todas las selecciones -->
<button type="button" id="save-selections" class="w-full mt-4 text-white bg-blue-700 hover:bg-blue-800">
    Guardar Todo
</button>
<script>
   document.getElementById('add-selection').addEventListener('click', function() {
    // Obtener valores seleccionados
    const section = document.getElementById('section_id').value;
    const degree = document.getElementById('degree_id').value;
    const course = document.getElementById('course_id').value;

    // Validar que todos los campos estén seleccionados
    if (!section || !degree || !course) {
        alert('Por favor, selecciona todos los campos');
        return;
    }

    // Obtener los textos de las opciones seleccionadas
    const sectionText = document.querySelector(`#section_id option[value="${section}"]`).text;
    const degreeText = document.querySelector(`#degree_id option[value="${degree}"]`).text;
    const courseText = document.querySelector(`#course_id option[value="${course}"]`).text;

    // Crear una nueva fila en la tabla con atributos data-*
    const tableBody = document.getElementById('selections-table').querySelector('tbody');
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td data-section-id="${section}">${sectionText}</td>
        <td data-degree-id="${degree}">${degreeText}</td>
        <td data-course-id="${course}">${courseText}</td>
        <td><button type="button" class="text-white bg-red-500 remove-selection">Eliminar</button></td>
    `;

    // Añadir la fila a la tabla
    tableBody.appendChild(newRow);

    // Limpiar selects después de agregar
    document.getElementById('section_id').value = '';
    document.getElementById('degree_id').value = '';
    document.getElementById('course_id').value = '';

    // Añadir evento para eliminar la fila
    newRow.querySelector('.remove-selection').addEventListener('click', function() {
        this.closest('tr').remove();
    });
});

document.getElementById('save-selections').addEventListener('click', function() {
    // Obtener el token CSRF
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Recolectar los datos
    const teachers_id = document.getElementById('teachers_id').value;
    const selections = [];

    document.querySelectorAll('#selections-table tbody tr').forEach(row => {
        const section_id = row.children[0].getAttribute('data-section-id');
        const degree_id = row.children[1].getAttribute('data-degree-id');
        const course_id = row.children[2].getAttribute('data-course-id');

        selections.push({ section_id, degree_id, course_id });
    });

    // Verificar si se han añadido selecciones
    if (selections.length === 0) {
        alert('No hay selecciones para guardar.');
        return;
    }

    // Enviar la solicitud POST
    fetch('assignment/newTeacherCourse', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
        },
        body: JSON.stringify({ teachers_id, selections })
    })
    .then(response => {
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            return response.json();
        } else {
            throw new Error('La respuesta no es JSON');
        }
    })
    .then(result => {
        if (result.success) {
            alert(result.message);
        } else {
            alert('Error: ' + result.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ocurrió un error: ' + error.message);
    });
});


    </script>
