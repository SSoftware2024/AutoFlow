<?php

use App\Models\User;
use App\Models\Client;
use App\Models\Company;
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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->nullable()->constrained();
            $table->foreignIdFor(User::class)->nullable()->constrained();
            $table->foreignIdFor(OperatorCashier::class)->nullable()->constrained();
            $table->foreignIdFor(Client::class)->nullable()->constrained();
            $table->string('name', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('cellphone', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
