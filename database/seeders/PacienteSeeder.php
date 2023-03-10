<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Paciente;
use Database\Factories\PacienteFactory;

class PacienteSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    Paciente::factory(10)->create();
  }
}
