<?php

use App\Models\Calendar\Event;
use App\Models\Calendar\Participants;
use App\Models\User;
use App\Models\Company;
use App\Models\DrivingSchool\Vehicles;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Calendar\SchedulingStandards;
use App\Models\Client;
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
            $table->string('name', 300);
            $table->foreignIdFor(Company::class)->nullable()->constrained();
            $table->foreignIdFor(User::class)->nullable()->constrained();
            $table->foreignId('professional_id')->nullable()->constrained('clients');
            $table->foreignIdFor(Client::class)->nullable()->constrained();
            $table->foreignIdFor(SchedulingStandards::class)->nullable()->constrained();//padrão de agendamento
            $table->foreignIdFor(Vehicles::class)->nullable()->constrained();
            $table->foreignIdFor(Event::class)->nullable()->constrained();
            $table->foreignIdFor(Participants::class)->nullable()->constrained();
            $table->datetime('date_start');
            $table->datetime('date_end');
            $table->boolean('is_all_day_long')->default(false);
            $table->text('description');
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
