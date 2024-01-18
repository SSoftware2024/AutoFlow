<?php

use App\Models\Cashier;
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
        Schema::create('cash_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Cashier::class)->nullable()->constrained();
            $table->enum('type_movement',['entry','exit']);
            $table->double('value', 8,2);
            $table->double('received_value', 8,2);
            $table->double('rest_money', 8,2);
            $table->string('reason')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_movements');
    }
};
