<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Soporte;
use Illuminate\Http\Request;

class SoporteController extends Controller
{
    public function create(Request $request)
    {
        $usuario = $request->user();

        // 1. Si no hay usuario logueado, mandarlo a iniciar sesión
        if (!$usuario) {
            return redirect()->route('login')->with('info', 'Debes iniciar sesión para enviar una sugerencia.');
        }

        // 2. Si entra un administrador desde la tienda pública, mandarlo a su panel
        if (strtolower($usuario->Rol) === 'admin' || strtolower($usuario->Rol) === 'administrador') {
            return redirect()->route('admin.soporte.index');
        }

        // 3. Validar que la cuenta tenga su perfil de cliente ligado
        if (!$usuario->cliente) {
            return back()->with('error', 'Tu usuario no tiene un perfil de cliente asignado en la base de datos.');
        }

        // 4. Obtener las sugerencias del cliente actual
        $misSugerencias = Soporte::where('IdCliente', $usuario->cliente->IdCliente)
            ->orderByDesc('Fecha')
            ->get();

        return view('soporte', compact('misSugerencias'));
    }

    public function store(Request $request)
    {
        $usuario = $request->user();

        if (!$usuario || !$usuario->cliente) {
            return back()->with('error', 'No tienes permisos para realizar esta acción.');
        }

        $data = $request->validate([
            'Asunto'       => ['required', 'string', 'max:150'],
            'Mensaje'      => ['required', 'string', 'max:2000'],
            'Calificacion' => ['nullable', 'integer', 'min:1', 'max:5'],
        ]);

        Soporte::create([
            'IdCliente'    => $usuario->cliente->IdCliente,
            'Asunto'       => $data['Asunto'],
            'Mensaje'      => $data['Mensaje'],
            'Calificacion' => $data['Calificacion'] ?? null,
            'Fecha'        => now(),
            'Estado'       => 'pendiente',
        ]);

        return back()->with('exito', 'Tu mensaje fue enviado. Te responderemos pronto.');
    }
}