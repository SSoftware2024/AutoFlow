<?php

use App\Models\User;
use App\Models\Client;
use App\Models\Company;
use App\Models\PaymentMethod;
use App\Models\InvoiceCategory;
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
        /** Contas a receber - receita */
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Company::class)->constrained();
            $table->foreignIdFor(Client::class)->nullable()->constrained();
            $table->foreignIdFor(PaymentMethod::class)->nullable()->constrained();
            $table->foreignIdFor(InvoiceCategory::class)->nullable()->constrained();
            $table->double('price',8,2);
            $table->tinyInteger('quantity_installments')->nullable();
            $table->text('information');
            $table->date('payment_date');
            $table->date('date_paid')->nullable();
            $table->enum('status',['wait','open','alert','expired','closed'])->nullable();
            $table->enum('type',['sale','service','other'])->default('sale');
            $table->string('type_other', 100)->nullable();
            $table->string('client_anonymous', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
