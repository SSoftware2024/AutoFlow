<?php

use App\Models\User;
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
        /** Contas a pagar */
        Schema::create('invoice_pays', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(PaymentMethod::class)->nullable()->constrained();
            $table->foreignIdFor(InvoiceCategory::class)->nullable()->constrained();
            $table->string('name', 100);
            $table->string('price', 8,2);
            $table->tinyInteger('quantity_installments')->nullable();
            $table->date('start_date');
            $table->date('end_paid');
            $table->date('date_paid');
            $table->enum('status',['wait','open','alert','expired','closed'])->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_pays');
    }
};
