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
        Schema::create('paciente', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('nome_mae')->nullable();
            $table->date('data_nascimento');
            $table->string('cpf', 11);
            $table->string('telefone',11) ;
            $table->char('sexo', 1) ;
            $table->string('endereco', 200) ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paciente');
    }
};
