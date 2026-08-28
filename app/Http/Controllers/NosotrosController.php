<?php

namespace App\Http\Controllers;

use App\Models\EmpresaInfo;

class NosotrosController extends Controller
{
    public function index()
    {
        $info = EmpresaInfo::first();
        return view('nosotros', compact('info'));
    }
}