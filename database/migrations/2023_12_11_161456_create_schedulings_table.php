<?php

use App\Models\User;
use App\Models\Client;
use App\Models\Company;
use App\Models\DrivingSchool\Vehicles;
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
        Schema::create('schedulings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->nullable()->constrained();
            $table->foreignIdFor(User::class)->nullable()->constrained();
            $table->foreignId('teacher_driving_id')->nullable()->constrained('clients');
            $table->foreignId('student_driving_id')->nullable()->constrained('clients');
            $table->foreignIdFor(Client::class)->nullable()->constrained();//'client_id' client padrão simples
            $table->foreignIdFor(Vehicles::class)->nullable()->constrained();
            $table->date('date_start');
            $table->date('date_end');
            $table->boolean('is_all_day_long')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedulings');
    }
};
