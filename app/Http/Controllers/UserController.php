<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Degree;
use App\Models\Courses;
use App\Models\Sections;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;

class UserController extends Controller
{
    public function show()
    {
        if(Auth::check()) {
            return redirect('/home');
        }

        $roles = Role::all()->pluck('name', 'id')->toArray(); // Convertir a array antes de pasar a la vista
        return view('auth.register', compact('roles'));
    }


    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create($request->validated());

            $roles = $request->input('roles', []);
            if (!is_array($roles)) {
                $roles = [$roles];
            }

            $roleNames = Role::whereIn('id', $roles)->pluck('name')->toArray();
            Log::info('Roles a sincronizar:', ['roles' => $roleNames]);

            $user->syncRoles($roleNames);
            Log::info('Roles sincronizados para el usuario:', ['user_id' => $user->id]);

            return redirect('/login')->with('success', 'Usuario creado correctamente');
        } catch (\Exception $e) {
            Log::error('Error al registrar el usuario: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Hubo un problema al crear el usuario. Inténtalo nuevamente.']);
        }
    }

    public function listUsers()
    {
        try {
            $roleId = request()->query('role_id');
            $search = request()->query('search');

            if ($roleId || $search) {

                $users = User::where('state', 1)
                    ->when($roleId, function ($query) use ($roleId) {
                        return $query->whereHas('roles', function ($q) use ($roleId) {
                            $q->where('roles.id', $roleId);
                        });
                    })
                    ->when($search, function ($query) use ($search) {
                        return $query->where('first_name', 'LIKE', "%{$search}%");
                    })
                    ->paginate(10)
                    ->appends([
                        'role_id' => $roleId,
                        'search' => $search
                    ]);

            } else {
                $users = User::where('state', [1])->paginate(10);
            }

            $roles = Role::all();
            $courses = Courses::all();
            $sections = Sections::all();
            $degrees = Degree::all();

            return view('user.listUsers', [
                'roles' => $roles,
                'users' => $users,
                'courses' => $courses,
                'sections' => $sections,
                'degrees' => $degrees,
            ]);
        } catch (\Exception $e) {
            return redirect('/users')->with('error', 'Ocurrió un problema.');
        }
    }


    public function showCreateForm()
    {

        $roles = Role::all()->pluck('name', 'id')->toArray();
        return view('user.createUser', compact('roles'));
    }

    public function createUser(Request $request)
    {
        try {
            // Validación de los datos del estudiante
            $validatedStudent = $request->validate([
              'email' => 'nullable',
              'username' => 'nullable',
              'first_name' => 'nullable',
              'second_name' => 'nullable',
              'first_lastname' => 'nullable',
              'second_lastname' => 'nullable',
              'dpi' => 'nullable',
              'phone' => 'nullable',
              'academic_degree' => 'nullable',
              'service_time' => 'nullable',
              'address' => 'nullable',
              'password' => 'nullable',
              'password_confirmation' => 'nullable|same:password',
            ]);

            // Crear el estudiante
            $user = User::create($validatedStudent);


            $roles = $request->input('roles', []);
            if (!is_array($roles)) {
                $roles = [$roles];
            }

            $roleNames = Role::whereIn('id', $roles)->pluck('name')->toArray();
            Log::info('Roles a sincronizar:', ['roles' => $roleNames]);

            $user->syncRoles($roleNames);
            Log::info('Roles sincronizados para el usuario:', ['user_id' => $user->id]);

            return redirect('/users')->with('message', 'Usuario creado correctamente');
        } catch (\Exception $e) {
            Log::error('Error al registrar el usuario: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Hubo un problema al crear el usuario. Inténtalo nuevamente.']);
        }
    }

    public function showEdit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all()->pluck('name', 'id');
        return view('user.editUsers', compact('user', 'roles'));
    }

    public function editUsers(Request $request, User $user)
    {
        try {
            $data = $request->validate([
                'username' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'first_name' => 'required',
                'second_name' => 'nullable',
                'first_lastname' => 'required',
                'second_lastname' => 'nullable',
                'dpi' => 'required',
                'phone' => 'required',
                'academic_degree' => 'required',
                'service_time' => 'required',
                'address' => 'required',
                'roles' => 'array',
                'roles.*' => 'exists:roles,id'
            ]);

            $user->update($data);

            if (isset($data['roles'])) {
                $roleNames = Role::whereIn('id', $data['roles'])
                    ->pluck('name')
                    ->toArray();
                $user->syncRoles($roleNames);
            } else {
                $user->syncRoles([]);
            }

            if (in_array('administracion', $roleNames)) {
                return redirect('/users')->with('message', 'Usuario editado correctamente');
            } else {
                return redirect('/teachers')->with('message', 'Usuario editado correctamente');
            }

        } catch (\Exception $e) {
            Log::error('Error al actualizar el usuario', ['error' => $e->getMessage()]);
            return redirect()
                ->back()
                ->with('error', 'Error al actualizar el usuario: ');
        }
    }


    public function disableUser($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->disable(); // Llama al método `disable` del modelo User
        }

        return redirect('/users'); // Redirecciona a la lista de usuarios
    }



    public function activeUser($id)
    {
        $user = User::find($id);
        $user->enable();
        return redirect('/users');
    }

    public function trashUsers()
    {
        try {
            $roleId = request()->query('role_id');
            $search = request()->query('search');

            if ($roleId || $search) {

                $users = User::where('state', 0)
                    ->when($roleId, function ($query) use ($roleId) {
                        return $query->whereHas('roles', function ($q) use ($roleId) {
                            $q->where('roles.id', $roleId);
                        });
                    })
                    ->when($search, function ($query) use ($search) {
                        return $query->where('first_name', 'LIKE', "%{$search}%");
                    })
                    ->paginate(10)
                    ->appends([
                        'role_id' => $roleId,
                        'search' => $search
                    ]);

            } else {
                $users = User::where('state', [0])->paginate(10);
            }

            $roles = Role::all();
            $courses = Courses::all();
            $sections = Sections::all();
            $degrees = Degree::all();

            return view('user.trashUsers', [
                'roles' => $roles,
                'users' => $users,
                'courses' => $courses,
                'sections' => $sections,
                'degrees' => $degrees,
            ]);
        } catch (\Exception $e) {
            return redirect('/users')->with('error', 'Ocurrió un problema.');
        }
    }
}
