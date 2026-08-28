<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $datos = $request->validate([
            'nombre'    => ['required', 'string', 'max:100'],
            'apellido'  => ['required', 'string', 'max:100'],
            'correo'    => ['required', 'email', 'max:150', 'unique:Usuarios,Correo'],
            'telefono'  => ['nullable', 'string', 'max:20'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'ciudad'    => ['nullable', 'string', 'max:100'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'correo.unique' => 'Este correo ya está registrado.',
            'password.min'  => 'La contraseña debe tener mínimo 8 caracteres.',
        ]);

        $usuario = DB::transaction(function () use ($datos) {
            $usuario = Usuario::create([
                'Correo'   => $datos['correo'],
                'Password' => Hash::make($datos['password']),
                'Rol'      => 'cliente',
            ]);

            Cliente::create([
                'IdUsuario' => $usuario->IdUsuario,
                'Nombre'    => $datos['nombre'],
                'Apellido'  => $datos['apellido'],
                'Direccion' => $datos['direccion'] ?? null,
                'Telefono'  => $datos['telefono'] ?? null,
                'Ciudad'    => $datos['ciudad'] ?? null,
            ]);

            return $usuario;
        });

        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect()->route('inicio')->with('exito', 'Cuenta creada correctamente. ¡Bienvenido a VortexShop!');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credenciales = $request->validate([
            'correo'   => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $recordarme = $request->boolean('recordarme');

        if (!Auth::attempt(['Correo' => $credenciales['correo'], 'password' => $credenciales['password']], $recordarme)) {
            return back()
                ->withErrors(['correo' => 'El correo o la contraseña no son correctos.'])
                ->onlyInput('correo');
        }

        $request->session()->regenerate();

        $usuario = Auth::user();

        if ($usuario->Rol === 'administrador') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->intended(route('inicio'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('inicio');
    }
}
