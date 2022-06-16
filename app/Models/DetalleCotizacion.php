<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCotizacion extends Model
{
    use HasFactory;

    public function producto()
    {
        return $this->hasOne(Producto::class,'id','IdProducto');
    }

    public function presentacion(){
        return $this->belongsTo(Presentacion::class, 'IdPresentacion');
    }

    public function precio(){
        return $this->belongsTo(Precio::class, 'IdPrecio');
    }
}
