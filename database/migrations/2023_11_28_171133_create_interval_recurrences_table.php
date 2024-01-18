<?php

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
        /** Recorrencia de despeza, intervalo customizado */
        Schema::create('interval_recurrences', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('interval');
            $table->enum('recurrence', ['daily','weekly','monthly','yearly']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interval_recurrences');
    }
};
