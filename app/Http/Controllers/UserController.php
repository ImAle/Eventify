<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Mostrar todos los usuarios desactivados
    public function index()
    {
        $users = User::where('actived', 0)->get();
        return view('admin.users', compact('users'));
    }

    // Activar usuario
    public function activate(User $user)
    {
        $user->update(['actived' => 1]);
        return redirect()->back()->with('success', 'Usuario activado.');
    }

    public function deactivate(User $user)
    {
        $user->update(['actived' => 0]);
        return redirect()->back()->with('success', 'Usuario desactivado.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'Usuario eliminado.');
    }

}
