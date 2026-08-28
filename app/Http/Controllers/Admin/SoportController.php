<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Soporte;
use Illuminate\Http\Request;

class SoportController extends Controller
{
    public function index(Request $request)
    {
        $query = Soporte::with('cliente');

        if ($request->filled('estado')) {
            $query->where('Estado', $request->estado);
        }

        $tickets = $query->orderByDesc('Fecha')->paginate(15)->withQueryString();

        return view('Admin.soport.index', compact('tickets'));
    }

    public function responder(Request $request, Soporte $soporte)
    {
        $data = $request->validate([
            'Respuesta' => ['required', 'string', 'max:2000'],
        ]);

        $soporte->update([
            'Respuesta'      => $data['Respuesta'],
            'FechaRespuesta' => now(),
            'Estado'         => 'respondido',
        ]);

        return back()->with('exito', 'Respuesta enviada al cliente.');
    }

    public function marcarEnRevision(Soporte $soporte)
    {
        $soporte->update(['Estado' => 'en_revision']);

        return back()->with('exito', 'Marcado como en revisión.');
    }
}