<?php

use App\Models\User;
use App\Models\Company;
use App\Models\Supplier;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->constrained();
            $table->foreignIdFor(Company::class)->nullable()->constrained();
            $table->foreignIdFor(Supplier::class)->nullable()->constrained();
            $table->string('name');
            $table->unsignedInteger('quantity');
            $table->string('custom_identifier', 300)->unique()->nullable();
            $table->string('bar_code', 355)->nullable();
            $table->string('unit_measurement', 20);
            $table->double('price', 8,2)->nullable();
            $table->boolean('is_fixed_value')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
