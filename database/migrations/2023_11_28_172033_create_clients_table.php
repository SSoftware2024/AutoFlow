<?php

use App\Models\Company;
use App\Models\TypeClient;
use App\Models\User;
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
        /** Clientes */
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->constrained();
            $table->foreignIdFor(Company::class)->nullable()->constrained();//apenas caso professor ou aluno
            $table->foreignId('responsible_id')->nullable()->constrained('users');
            $table->string('name', 100);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->string('street', 200)->nullable();
            $table->string('neighborhood', 200)->nullable();
            $table->string('number_house',10)->nullable();
            $table->string('cpf',30)->nullable();
            $table->string('rg',30)->nullable();
            $table->string('cellphone',30)->nullable();
            $table->date('birth_date')->nullable();
            $table->text('description')->nullable();
            $table->string('type_client', 255); //enum, veja enum type_client
            $table->boolean('active')->default(true);
            $table->string('responsible_anonymous',100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
