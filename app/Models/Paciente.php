<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $table = "paciente";
    use HasFactory;

    protected $fillable  = [
        "nome",
        "nome_mae",
        "data_nascimento",
        "cpf",
        "telefone",
        "sexo",
        "endereco"
    ];
}
