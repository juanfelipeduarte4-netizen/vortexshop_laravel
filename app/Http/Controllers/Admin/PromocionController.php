<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Promocion;
use Illuminate\Http\Request;

class PromocionController extends Controller
{
    public function index()
    {
        $promociones = Promocion::withCount('productos')->orderByDesc('FechaInicio')->paginate(15);

        return view('Admin.promociones.index', compact('promociones'));
    }

    public function create()
    {
        $productos = Producto::where('Estado', 'activo')->orderBy('Nombre')->get();

        return view('Admin.promociones.create', compact('productos'));
    }

    public function store(Request $request)
    {
        $data = $this->validarPromocion($request);

        $promocion = Promocion::create([
            'Descripcion'         => $data['Descripcion'] ?? null,
            'PorcentajeDescuento' => $data['PorcentajeDescuento'],
            'FechaInicio'         => $data['FechaInicio'],
            'FechaFin'            => $data['FechaFin'],
        ]);

        $promocion->productos()->sync($data['productos']);

        return redirect()->route('admin.promociones.index')->with('exito', 'Promoción creada correctamente.');
    }

    public function edit(Promocion $promocion)
    {
        $productos = Producto::where('Estado', 'activo')->orderBy('Nombre')->get();
        $seleccionados = $promocion->productos()->pluck('Producto.IdProducto')->all();

        return view('Admin.promociones.edit', compact('promocion', 'productos', 'seleccionados'));
    }

    public function update(Request $request, Promocion $promocion)
    {
        $data = $this->validarPromocion($request);

        $promocion->update([
            'Descripcion'         => $data['Descripcion'] ?? null,
            'PorcentajeDescuento' => $data['PorcentajeDescuento'],
            'FechaInicio'         => $data['FechaInicio'],
            'FechaFin'            => $data['FechaFin'],
        ]);

        $promocion->productos()->sync($data['productos']);

        return redirect()->route('admin.promociones.index')->with('exito', 'Promoción actualizada.');
    }

    public function destroy(Promocion $promocion)
    {
        $promocion->productos()->detach();
        $promocion->delete();

        return back()->with('exito', 'Promoción eliminada.');
    }

    private function validarPromocion(Request $request): array
    {
        return $request->validate([
            'Descripcion'         => ['nullable', 'string', 'max:1000'],
            'PorcentajeDescuento' => ['required', 'numeric', 'min:1', 'max:100'],
            'FechaInicio'         => ['required', 'date'],
            'FechaFin'            => ['required', 'date', 'after:FechaInicio'],
            'productos'           => ['required', 'array', 'min:1'],
            'productos.*'         => ['integer', 'exists:Producto,IdProducto'],
        ], [
            'FechaFin.after'     => 'La fecha de fin debe ser posterior a la fecha de inicio.',
            'productos.required' => 'Selecciona al menos un producto para la promoción.',
        ]);
    }
}