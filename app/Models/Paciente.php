<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Paciente extends Model
{
  use HasFactory;

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'pacientes';

  protected $fillable = [
    'cpf',
    'cns',
    'nome',
    'nome_mae',
    'cep',
    'logradouro',
    'complemento',
    'bairro',
    'localidade',
    'uf',
    'ibge',
    'gia',
    'ddd',
    'siafi',
    'data_nascimento',
    'imagem'
  ];

  public function rules()
  {
    return [
      'cpf' => 'required|unique:pacientes,cpf',
      'cns' => 'required|unique:pacientes,cns',
      'nome' => 'required',
      'nome_mae' => 'required',
      'cep' => 'required',
      'data_nascimento' => 'required',
      'imagem' => 'required|file|mimes:png,jpg,jpeg'
    ];
  }

  public function feedback()
  {
    return [
      'required' => 'O campo :attribute é obrigatório!',
      'cpf.unique' => 'Este CPF já está cadastrado!',
      'cns.unique' => 'Este CNS já está cadastrado!',
      'imagem.mimes' => 'O arquivo deve ser uma imagem do tipo PNG, JPEG ou JPG.'
    ];
  }
}
