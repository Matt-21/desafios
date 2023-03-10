<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Paciente;

class PacienteController extends Controller
{
  protected $paciente;

  public function __construct(Paciente $paciente)
  {
    $this->paciente = $paciente;
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return response()->json($this->paciente->all(), 200);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate($this->paciente->rules(), $this->paciente->feedback());

    $image = $request->file('imagem');
    $image_urn = $image->store('imgs', 'public');

    $response = Http::get('https://viacep.com.br/ws/'.$request->cep.'/json/');
    $data = $response->json();

    if(isset($data['cep'])) {
      $dados = [
        'cpf' => $request->cpf,
        'cns' => $request->cns,
        'nome' => $request->nome,
        'nome_mae' => $request->nome_mae,
        'cep' => isset($data['cep']) ? $data['cep'] : null,
        'logradouro' => isset($data['logradouro']) ? $data['logradouro'] : null,
        'complemento' => isset($data['complemento']) ? $data['complemento'] : null,
        'bairro' => isset($data['bairro']) ? $data['bairro'] : null,
        'localidade' => isset($data['localidade']) ? $data['localidade'] : null,
        'uf' => isset($data['uf']) ? $data['uf'] : null,
        'ibge' => isset($data['ibge']) ? $data['ibge'] : null,
        'gia' => isset($data['gia']) ? $data['gia'] : null,
        'ddd' => isset($data['ddd']) ? $data['ddd'] : null,
        'siafi' => isset($data['siafi']) ? $data['siafi'] : null,
        'data_nascimento' => $request->data_nascimento,
        'imagem' => $image_urn
      ];
    }

    $create = $this->paciente->create($dados);

    return response()->json($create, 201);
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    if (is_null($this->paciente->find($id))) {
      return response()->json(['erro' => 'Paciente não encontrado na base de dados!'], 404);
    }
    return response()->json($this->paciente->find($id), 200);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $paciente = $this->paciente->find($id);
    if ($paciente === null) {
      return response()->json(['erro' => 'Paciente não encontrado na base de dados!'], 404);
    }
    if ($request->method() === 'PATCH') {
      $dynamicRules = array();

      foreach ($this->paciente->rules() as $input => $rules) {
        if (array_key_exists($input, $request->all())) {
          $dynamicRules[$input] = $rules;
        }
      }
      $request->validate($dynamicRules, $paciente->feedback());
    }
    $request->validate($paciente->rules(), $paciente->feedback());


    if ($request->file('imagem')) {
      Storage::disk('public')->delete($paciente->imagem);
    }

    $image = $request->file('imagem');
    $image_urn = $image->store('imgs', 'public');

    $response = Http::get('https://viacep.com.br/ws/'.$request->cep.'/json/');
    $data = $response->json();

    if(isset($data['cep'])) {
      $dados = [
        'cpf' => $request->cpf,
        'cns' => $request->cns,
        'nome' => $request->nome,
        'nome_mae' => $request->nome_mae,
        'cep' => isset($data['cep']) ? $data['cep'] : null,
        'logradouro' => isset($data['logradouro']) ? $data['logradouro'] : null,
        'complemento' => isset($data['complemento']) ? $data['complemento'] : null,
        'bairro' => isset($data['bairro']) ? $data['bairro'] : null,
        'localidade' => isset($data['localidade']) ? $data['localidade'] : null,
        'uf' => isset($data['uf']) ? $data['uf'] : null,
        'ibge' => isset($data['ibge']) ? $data['ibge'] : null,
        'gia' => isset($data['gia']) ? $data['gia'] : null,
        'ddd' => isset($data['ddd']) ? $data['ddd'] : null,
        'siafi' => isset($data['siafi']) ? $data['siafi'] : null,
        'data_nascimento' => $request->data_nascimento,
        'imagem' => $image_urn
      ];
    }

    $paciente->update($dados);

    return response()->json($paciente, 200);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $paciente = $this->paciente->find($id);

    if ($paciente) {
      Storage::disk('public')->delete($paciente->imagem);
    }

    if ($paciente === null) {
      return response()->json(['erro' => 'Paciente não encontrado na base de dados!'], 404);
    }

    $paciente->delete();
    return response()->json(['msg' => 'Paciente removido com sucesso!'], 200);
  }

  public function search(Request $request)
  {

    if ($request->query('cpf') and count($request->query()) == 1) {
      $filterData = Paciente::where("cpf", 'LIKE', '%' . $request->query('cpf') . '%')
        ->get();
      return $filterData;
    }

    if ($request->query('nome') and count($request->query()) == 1) {
      $filterData = Paciente::where("nome", 'LIKE', '%' . $request->query('nome') . '%')
        ->get();
      return $filterData;
    }

    if ($request->has(['nome', 'cpf']) and count($request->query()) == 2) {
      $filterData = Paciente::where("nome", 'LIKE', '%' . $request->query('nome') . '%')
                              ->orWhere("cpf", 'LIKE', '%' . $request->query('cpf') . '%')
                              ->get();
      return $filterData;
    }

  }
}
