<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    //
    public function crear(){
        return view('proveedor.formularioProveedor');
    }
}
