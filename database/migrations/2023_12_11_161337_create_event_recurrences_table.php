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
        Schema::create('event_recurrences', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->nullable()->constrained();
            $table->foreignIdFor(User::class)->nullable()->constrained();
            $table->smallInteger('interval');
            $table->enum('recurrence', ['daily','weekly','monthly','yearly']);
            $table->smallInteger('week_day')->nullable();
            $table->smallInteger('month_day')->nullable();
            $table->integer('end_ocurrence')->default(0); //depois 3 ocorrencias
            $table->date('end_ocurrence_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_recurrences');
    }
};
