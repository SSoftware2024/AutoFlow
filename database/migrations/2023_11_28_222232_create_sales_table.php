<?php

use App\Models\User;
use App\Models\Client;
use App\Models\Company;
use App\Models\PaymentMethod;
use App\Models\OperatorCashier;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(OperatorCashier::class)->nullable()->constrained();
            $table->foreignIdFor(User::class)->nullable()->constrained();
            $table->foreignIdFor(Company::class)->nullable()->constrained();
            $table->foreignIdFor(Client::class)->nullable()->constrained();
            $table->foreignIdFor(PaymentMethod::class)->nullable()->constrained();
            $table->datetime('date_sold');
            $table->datetime('date_paid');
            $table->double('price',8,2);
            $table->double('rest_money',8,2)->nullable();
            $table->string('client_name',100)->nullable();
            $table->boolean('is_promissory')->default(false);
            $table->enum('sold_by',['operator_cashier','user'])->default('operator_cashier'); //venda só pode ser reaberta se ainda estiver no seu dia
            $table->enum('status',['open','closed','reopened','canceled'])->default('open'); //venda só pode ser reaberta se ainda estiver no seu dia
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
