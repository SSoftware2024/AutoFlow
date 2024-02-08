<?php

use App\Models\Cashier;
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
        Schema::create('history_cashiers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Cashier::class)->nullable()->constrained();
            $table->double('initial_value',8,2);
            $table->double('final_value',8,2);
            $table->date('date');
            $table->enum('status',['open','closed','reopned']);
            $table->string('reason',100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_cashiers');
    }
};
