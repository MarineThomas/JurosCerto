<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emprestimo extends Model
{
    protected $fillable = [

        'cliente_id',
        'valor_principal',
        'tipo_juros',
        'taxa_juros',
        'num_parcelas',
        'data_inicio',
        'status',
    ];

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function parcelas(){
        return $this->hasMany(Parcela::class);
    }

}
