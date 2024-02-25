<?php
namespace Database\Factories\Financial;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Financial\PaymentPlan;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<PaymentPlan>
 */
class PaymentPlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->randomElement(['Básico', 'Avançado', 'Preminum']),
            'price' => $this->faker->randomFloat(2, 100, 99999.99),
            'permissions' => '{"sale": {"erp": {"name": "ERP", "value": true}, "pdv": {"name": "PDV", "value": true}, "financial": {"name": "Financeiro", "value": true}}, "schedulling": {"common": {"name": "Comum", "value": true}, "driving_scholl": {"name": "Auto Escola", "value": true}}}'
        ];
    }
}
