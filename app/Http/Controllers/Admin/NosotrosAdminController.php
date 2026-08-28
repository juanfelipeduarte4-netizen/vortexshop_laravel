<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmpresaInfo;
use Illuminate\Http\Request;

class NosotrosAdminController extends Controller
{
    public function show()
    {
        $info = EmpresaInfo::first() ?? new EmpresaInfo();
        return view('admin.nosotros.edit', compact('info'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'Nombre'  => 'required|string|max:255',
            'Mision'  => 'required|string',
            'Vision'  => 'required|string',
            'Valores' => 'nullable|string',
            'Historia'=> 'nullable|string',
        ]);

        $info = EmpresaInfo::first() ?? new EmpresaInfo();
        $info->Nombre = $request->Nombre;
        $info->Mision = $request->Mision;
        $info->Vision = $request->Vision;
        $info->Valores = $request->Valores;
        $info->Historia = $request->Historia;
        $info->save();

        return redirect()->route('admin.nosotros')->with('success', 'Información de VortexShop actualizada.');
    }
}
