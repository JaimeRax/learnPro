<section>
    <li><a href="{{ '/home' }}"> <i class="fa-solid fa-house"></i> Inicio</a></li>


    @can('admin')
        <li>

            <details>

                <summary><i class="fa-solid fa-briefcase"></i>Recursos</summary>

                <ul>

                    <li><a href="{{ '/sections' }}"><i class="fa-solid fa-folder"></i>Secciones</a></li>

                    <li><a href="{{ '/degrees' }}"><i class="fa-solid fa-graduation-cap"></i>Grados</a></li>

                    <li><a href="{{ '/courses' }}"><i class="fa-solid fa-chalkboard-teacher"></i> Cursos</a></li>

                    <li><a href="{{ '/collaborations' }}"><i class="fa-solid fa-coins"></i> Colaboraciones</a></li>
                </ul>

            </details>

        </li>

        </li>

        <li><a href="{{ '/student' }}"><i class="fa-solid fa-user-plus"></i> Estudiantes</a></li>

        <li><a href="{{ '/payments' }}"><i class="fa-solid fa-money-bill-wave"></i> Pagos</a></li>

        <li>

            <details>

                <summary><i class="fa-solid fa-tasks"></i>Asignaciones generales</summary>

                <ul>
                    <li><a href="{{ '/teachers' }}"><i class="fa-solid fa-user-check"></i>Asignaciones de Docentes</a>
                    </li>


                    <li><a href="{{ '/assignment/student' }}"><i class="fa-solid fa-clipboard-list"></i> Asignaciones de
                            estudiantes</a></li>
                </ul>

            </details>

        </li>

        <li><a href="{{ '/users' }}"><i class="fa-solid fa-users"></i>Usuarios</a></li>

        <li><a href="{{ '/report/payments' }}"><i class="fa-solid fa-file-alt"></i>Reportes</a></li>
    @endcan


    @can('teacher')
        <li><a href="{{ '/teachers/myCourses' }}"><i class="fa-solid fa-book"></i> Mis cursos</a></li>

        <li><a href="{{ '/ratings' }}"><i class="fa-solid fa-clipboard-check"></i> Mis notas</a></li>

        <li><a href="{{ '/activity' }}"><i class="fa-solid fa-calendar-alt"></i> Mis actividades</a></li>

        <li><a href="{{ '/report/report' }}"><i class="fa-solid fa-file-alt"></i> Reportes</a></li>
    @endcan





</section>
