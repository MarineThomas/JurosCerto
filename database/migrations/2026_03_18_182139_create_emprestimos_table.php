<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('emprestimos', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->decimal('valor_principal', 10, 2);            
            $table->enum('tipo_juros',['simples','composto']);
            $table->decimal('taxa_juros', 5 ,2);
            $table->integer('num_parcelas');
            $table->date('data_inicio');
            $table->enum('status',['ativo','quitado','em_atraso'])->default('ativo');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emprestimos');
    }
};
