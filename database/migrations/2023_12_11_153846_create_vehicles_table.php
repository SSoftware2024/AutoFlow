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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->nullable()->constrained();
            $table->foreignIdFor(User::class)->nullable()->constrained();
            $table->string('surname', 100)->nullable();
            $table->string('plate', 100)->nullable();
            $table->enum('category', ['ACC','A','B','C','D','E'])->nullable();
            $table->date('ipva_generate')->nullable();
            $table->double('ipva_value', 8,2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
