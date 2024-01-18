<?php

use App\Models\OperatorCashier;
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
        Schema::create('cash_payment_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(OperatorCashier::class)->nullable()->constrained();
            $table->double('price_paid')->nullable();
            $table->double('value_wage')->nullable();
            $table->string('reason',200)->nullable();
            $table->enum('status',['open','paid'])->default('open');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_payment_histories');
    }
};
