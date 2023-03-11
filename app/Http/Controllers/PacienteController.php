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
    $this->paciente->fill($request->all());

    if ($request->file('imagem')) {
      $image = $request->file('imagem');
      $image_urn = $image->store('imgs', 'public');

      $this->paciente->imagem = isset($image_urn) ? $image_urn : '';
    }

    $response = Http::get('https://viacep.com.br/ws/'.$request->cep.'/json/');

    if($response->ok()) {
      $data = $response->json();

      $this->paciente->cep = isset($data['cep']) ? $data['cep'] : null;
      $this->paciente->logradouro = isset($data['logradouro']) ? $data['logradouro'] : null;
      $this->paciente->complemento = isset($data['complemento']) ? $data['complemento'] : null;
      $this->paciente->bairro = isset($data['bairro']) ? $data['bairro'] : null;
      $this->paciente->localidade = isset($data['localidade']) ? $data['localidade'] : null;
      $this->paciente->uf = isset($data['uf']) ? $data['uf'] : null;
      $this->paciente->ibge = isset($data['ibge']) ? $data['ibge'] : null;
      $this->paciente->gia = isset($data['gia']) ? $data['gia'] : null;
      $this->paciente->ddd = isset($data['ddd']) ? $data['ddd'] : null;
      $this->paciente->siafi = isset($data['siafi']) ? $data['siafi'] : null;
    }

    $this->paciente->save();

    return response()->json($this->paciente, 201);
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

      foreach ($paciente->rules() as $input => $rules) {
        if (array_key_exists($input, $request->all())) {
          $dynamicRules[$input] = $rules;
        }
      }
      $request->validate($dynamicRules, $paciente->feedback());
    } else {
      $request->validate($paciente->rules(), $paciente->feedback());
    }

    $paciente->fill($request->all());

    if ($request->file('imagem')) {
      Storage::disk('public')->delete($paciente->imagem);

      $image = $request->file('imagem');
      $image_urn = $image->store('imgs', 'public');

      $paciente->imagem = isset($image_urn) ? $image_urn : '';
    }

    $response = Http::get('https://viacep.com.br/ws/'.$request->cep.'/json/');

    if($response->ok()) {
      $data = $response->json();

      $paciente->cep = isset($data['cep']) ? $data['cep'] : null;
      $paciente->logradouro = isset($data['logradouro']) ? $data['logradouro'] : null;
      $paciente->complemento = isset($data['complemento']) ? $data['complemento'] : null;
      $paciente->bairro = isset($data['bairro']) ? $data['bairro'] : null;
      $paciente->localidade = isset($data['localidade']) ? $data['localidade'] : null;
      $paciente->uf = isset($data['uf']) ? $data['uf'] : null;
      $paciente->ibge = isset($data['ibge']) ? $data['ibge'] : null;
      $paciente->gia = isset($data['gia']) ? $data['gia'] : null;
      $paciente->ddd = isset($data['ddd']) ? $data['ddd'] : null;
      $paciente->siafi = isset($data['siafi']) ? $data['siafi'] : null;
    }

    $paciente->save();

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
