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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cpf', 11)->unique();
            $table->string('cns', 20)->unique();
            $table->string('nome', 50);
            $table->string('nome_mae', 50);
            $table->string('cep', 10);
            $table->string('logradouro', 200)->nullable();
            $table->string('complemento', 200)->nullable();
            $table->string('bairro', 120)->nullable();
            $table->string('localidade', 100)->nullable();
            $table->string('uf', 2)->nullable();
            $table->string('ibge', 12)->nullable();
            $table->string('gia', 10)->nullable();
            $table->string('ddd', 2)->nullable();
            $table->string('siafi', 10)->nullable();
            $table->date('data_nascimento');
            $table->string('imagem');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
