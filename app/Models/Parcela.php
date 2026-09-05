<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parcela extends Model
{
    protected $fillable = [
        'emprestimo_id',
        'numero',
        'valor',
        'data_vencimento',
        'data_pagamento',
        'status',
    ];

    public function emprestimo(){
        return $this->belongsTo(Emprestimo::class);
    }
}

