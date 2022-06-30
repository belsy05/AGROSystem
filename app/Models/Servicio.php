<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    public function personal(){
        return $this->belongsTo(Personal::class, 'empleado_id');
    }

    public function clientes(){
        return $this->belongsTo(Cliente::class, 'cliente_id');
    } 
}
