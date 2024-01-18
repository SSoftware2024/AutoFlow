<?php

use App\Models\Income;
use App\Models\InvoicePay;
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
        /** Parcelamentos */
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Income::class)->nullable()->constrained();
            $table->foreignIdFor(InvoicePay::class)->nullable()->constrained();
            $table->date('payment_date');
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
        Schema::dropIfExists('installments');
    }
};
