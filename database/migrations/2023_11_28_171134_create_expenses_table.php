<?php

use App\Models\Company;
use App\Models\PaymentPlan;
use App\Models\InvoiceCategory;
use App\Models\IntervalRecurrence;
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
        /** Desepesas */
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->constrained();
            $table->foreignIdFor(Company::class)->nullable()->constrained();
            $table->foreignIdFor(PaymentPlan::class)->nullable()->constrained();
            $table->foreignIdFor(IntervalRecurrence::class)->nullable()->constrained();
            $table->foreignIdFor(InvoiceCategory::class)->nullable()->constrained();
            $table->string('title');
            $table->double('price', 8,2);
            $table->boolean('fixed_variable')->default(false);
            $table->boolean('recurrent')->default(false);
            $table->enum('interval_recurrence',['daily','weekly','monthly','yearly','custom'])->nullable();
            $table->boolean('is_invoice_due_date')->default(false);
            $table->date('invoice_due_date')->nullable();
            $table->date('payment_date')->nullable();
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
        Schema::dropIfExists('expenses');
    }
};
