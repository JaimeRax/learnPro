<section>
    <li><a href="{{ '/home' }}"> <i class="fa-solid fa-house"></i> Inicio</a></li>


    @can('admin')

    <li>

        <details>

        <summary><i class="fa-solid fa-people-arrows"></i> Recursos</summary>

        <ul>

        <li><a href="{{ '/sections' }}"><i class="fa-solid fa-users-line"></i> Secciones</a></li>

        <li><a href="{{ '/degrees' }}"><i class="fa-solid fa-users-line"></i> Grados</a></li>

        <li><a href="{{ '/courses' }}"><i class="fa-solid fa-users-line"></i> Cursos</a></li>

        </li>

        </ul>

        </details>

    </li>

    @endcan

    @can('admin')
    <li><a href="{{ '/teachers' }}"><i class="fa-solid fa-user-plus"></i> Docentes</a></li>

    <li><a href="{{ '/student' }}"><i class="fa-solid fa-user-plus"></i> Estudiantes</a></li>

    <li><a href="{{ '/payments' }}"><i class="fa-solid fa-map-location-dot"></i> Pagos</a></li>

    <li><a href="{{ '/assignment' }}"><i class="fa-solid fa-map-location-dot"></i> Asignaciones</a></li>

    <li><a href="{{ '/users' }}"><i class="fa-solid fa-user-plus"></i> Usuarios</a></li>

    @endcan


    @can('teacher')

    <li><a href="{{ '/teachers/myCourses' }}"><i class="fa-solid fa-map-location-dot"></i> Mis cursos</a></li>

    <li><a href="{{ '/ratings' }}"><i class="fa-solid fa-map-location-dot"></i> Mis notas</a></li>


    @endcan


    <li><a href="#"> <i class="fa-solid fa-file-pdf"></i> Reportes</a></li>

</section>
