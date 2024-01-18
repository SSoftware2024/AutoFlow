<?php

namespace Database\Factories;

use App\Models\PaymentPlan;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = FakerFactory::create('pt_BR');
        return [
            'name' => $faker->company(),
            'surname' => $faker->companySuffix(),
            'cnpj' => $faker->cnpj()
        ];
    }
}
