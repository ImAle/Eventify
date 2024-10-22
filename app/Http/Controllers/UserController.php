<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Mostrar todos los usuarios desactivados
    public function index()
    {
        $users = User::where('role', '!=','admin')->get();
        return view('admin.users', compact('users'));
    }

    // Activar usuario
    public function activate($id)
    {   
        $user = User::findOrFail($id);
        $user-> actived = 1;
        $user->save();
        return redirect()->back()->with('success', 'Usuario activado.');
    }

    public function deactivate($id)
    {
        $user = User::findOrFail($id);
        $user-> actived = 0;
        $user->save();
        return redirect()->back()->with('success', 'Usuario desactivado.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'Usuario eliminado.');
    }

}
