<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Mostrar todos los usuarios desactivados
    public function index()
{
    $users = User::where('role', '!=', 'admin')
                 ->where('deleted', '!=', 1)
                 ->get();

    return view('admin.users', compact('users'));
}


    // Activar usuario
    public function activate($id)
    {
        $user = User::findOrFail($id);
        $user->actived = 1;
        $user->save();
        return redirect()->back()->with('success', 'Usuario activado.');
    }

    public function deactivate($id)
    {
        $user = User::findOrFail($id);
        $user->actived = 0;
        $user->save();
        return redirect()->back()->with('success', 'Usuario desactivado.');
    }

    public function destroy(User $user)
    {
        $user->deleted = 1; // Cambiar el campo delete a 1
        $user->save();

        return redirect()->back()->with('success', 'Usuario marcado como eliminado.');
    }


    // Muestra el formulario con los datos del usuario
    public function edit($id)
    {
        // Busca el usuario por ID
        $user = User::findOrFail($id);

        // Retorna la vista con los datos del usuario
        return view('admin.user_edit', compact('user'));
    }

    // Actualiza el nombre del usuario
    public function update(Request $request, $id)
    {
        // Validamos solo el campo del nombre
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Busca el usuario por ID
        $user = User::findOrFail($id);

        // Actualiza el nombre
        $user->update([
            'name' => $request->input('name'),
        ]);

        // Redirige de vuelta con un mensaje de éxito
        return redirect()->route('user.edit', $id)->with('success', 'Nombre actualizado con éxito.');
    }
}
