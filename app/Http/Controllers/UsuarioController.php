<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UsuarioRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Redirect;

class UsuarioController extends Controller
{
    public function __construct()
    {
        // Asegura que todas las rutas de este controlador requieran autenticación
        $this->middleware('auth');
    }

    /**
     * Mostrar listado de usuarios.
     */
    public function index(Request $request): View
    {
        $users = User::paginate(15);

        return view('usuarios.index', compact('users'))
            ->with('i', ($request->input('page', 1) - 1) * $users->perPage());
    }

    /**
     * Formulario para crear un nuevo usuario.
     */
    public function create(): View
    {
        $user = new User();

        return view('usuarios.create', compact('user'));
    }

    /**
     * Almacenar un nuevo usuario.
     */
    public function store(UsuarioRequest $request): RedirectResponse
    {
        User::create($request->validated());

        return Redirect::route('usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Mostrar los detalles de un usuario.
     */
    public function show(User $usuario): View
    {
        // Pasamos la variable como 'user' para que las vistas la reciban uniforme
        return view('usuarios.show', ['user' => $usuario]);
    }

    /**
     * Formulario para editar un usuario.
     */
    public function edit(User $usuario): View
    {
        return view('usuarios.edit', ['user' => $usuario]);
    }

    /**
     * Actualizar un usuario existente.
     */
    public function update(UsuarioRequest $request, User $usuario): RedirectResponse
    {
        // Obtén sólo los datos validados
        $data = $request->validated();

        // Si la contraseña viene vacía, la removemos
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $usuario->update($data);

        return Redirect::route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Eliminar un usuario.
     */
    public function destroy(User $usuario): RedirectResponse
    {
        $usuario->delete();

        return Redirect::route('usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
