<?php

use App\Models\User;
use App\Models\Company;
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
        /** Historico Pagamento apenas do sistema */
        Schema::create('payment_historie_systems', function (Blueprint $table) {
            $table->foreignIdFor(Company::class)->constrained();
            $table->foreignIdFor(User::class)->nullable()->constrained();
            $table->double('price',8,2);
            $table->date('payment_date');
            $table->date('date_paid')->nullable();
            $table->enum('status',['wait','open','alert','expired','closed'])->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_historie_systems');
    }
};
