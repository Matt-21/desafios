<?php

namespace Database\Factories;

use App\Models\Paciente;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Paciente>
 */
class PacienteFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Paciente::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition(): array
  {
    $randomImages = [
      'https://cdn.pixabay.com/photo/2023/01/11/18/26/bird-7712475_960_720.jpg',
      'https://cdn.pixabay.com/photo/2023/01/07/11/30/alpine-7703065_640.jpg',
      'https://cdn.pixabay.com/photo/2023/01/14/22/23/geometric-7719159_960_720.png',
      'https://cdn.pixabay.com/photo/2023/02/04/14/22/fish-7767315_960_720.jpg',
      'https://cdn.pixabay.com/photo/2023/01/10/10/47/space-7709489_960_720.jpg',
      'https://cdn.pixabay.com/photo/2022/12/01/17/52/sea-7629517_960_720.jpg',
      'https://cdn.pixabay.com/photo/2022/11/11/01/46/headland-7584031_960_720.jpg',
      'https://cdn.pixabay.com/photo/2022/11/17/17/11/sea-7598498_960_720.jpg',
      'https://cdn.pixabay.com/photo/2023/03/03/20/15/science-fiction-7828391_960_720.jpg',
      'https://cdn.pixabay.com/photo/2023/02/28/18/26/mountain-7821542_960_720.jpg',
      'https://cdn.pixabay.com/photo/2023/02/25/14/05/grey-wolf-7813349_960_720.jpg'
    ];

    $randomCep= [
      72146201,
      72225031,
      72015015,
      72146204,
      72015025,
      72225093,
      72146207,
      72225015,
      72023420,
      72225046
    ];

    $response = Http::get('https://viacep.com.br/ws/'.$randomCep[rand(0, 10)].'/json/');
    $data = $response->json();

    return [
      'cpf' => $this->faker->numerify('###########'),
      'cns' => $this->faker->numerify('###############'),
      'nome' => $this->faker->name,
      'nome_mae' => $this->faker->name,
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
      'data_nascimento' => $this->faker->date('Y-m-d', 'now'),
      'imagem' => $randomImages[rand(0, 10)]
    ];
  }
}
