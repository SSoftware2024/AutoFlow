<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Team;
use App\Models\User;
use App\Models\Client;
use App\Models\PaymentPlan;
use App\Models\Administrator;
use App\Models\Company;
use App\Models\OperatorCashier;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Administrator::factory(2)->create();
        // User::factory(3)->create();
        $payments = PaymentPlan::factory(3)->create();

        foreach ($payments as  $value) {
            $company = Company::factory()
            ->for($value)
            ->create();
            $user = User::factory()
            ->for($company)
            ->create();
            Client::factory()
            ->for($company)
            ->for($user)
            ->create();
            //operator cashier
            OperatorCashier::factory()
            ->for($user)
            ->for($company)->create();
        }

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
