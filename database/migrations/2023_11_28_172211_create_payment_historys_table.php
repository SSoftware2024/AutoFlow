<?php

use App\Models\User;
use App\Models\Financial\Income;
use App\Models\Company;
use App\Models\Financial\Expense;
use App\Models\Financial\InvoicePay;
use App\Models\Financial\PaymentMethod;
use App\Models\Financial\SalaryHistory;
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
        /** Despezas, contas pagas */
        Schema::create('payment_historys', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Company::class)->constrained();
            $table->foreignIdFor(Expense::class)->nullable()->constrained();
            $table->foreignIdFor(PaymentMethod::class)->nullable()->constrained();
            $table->foreignIdFor(Income::class)->nullable()->constrained();
            $table->foreignIdFor(InvoicePay::class)->nullable()->constrained();
            $table->foreignIdFor(SalaryHistory::class)->nullable()->constrained();
            $table->double('variable_price')->nullable();
            $table->date('date_paid')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_historys');
    }
};
