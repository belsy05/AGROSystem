<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    public function personals(){
        return $this->belongsTo(Personal::class, 'personal_id');
    }

    public function clientes(){
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
