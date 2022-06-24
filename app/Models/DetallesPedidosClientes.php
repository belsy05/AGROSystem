<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallesPedidosClientes extends Model
{
    use HasFactory;

    public function producto()
    {
        return $this->hasOne(Producto::class,'id','IdProducto');
    }

    public function presentacion(){
        return $this->belongsTo(Presentacion::class, 'IdPresentacion');
    }

   
}
