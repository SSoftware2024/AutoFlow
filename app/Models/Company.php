<?php

namespace App\Models;

use App\Models\Sale;
use App\Models\User;
use App\Models\Client;
use App\Models\Income;
use App\Models\Cashier;
use App\Models\Expense;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\InvoicePay;
use App\Models\PaymentPlan;
use App\Models\PaymentMethod;
use App\Models\SalaryHistory;
use App\Models\PaymentHistory;
use App\Models\InvoiceCategory;
use App\Models\OperatorCashier;
use App\Models\PaymentHistorySystem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;
    /** Relationship */
    /** ==== 1 ==== */
    public function paymentPlan(): BelongsTo
    {
        return $this->belongsTo(PaymentPlan::class);
    }
    /** ==== 1-N ==== */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
    public function paymentHistorySystem(): HasMany
    {
        return $this->hasMany(PaymentHistorySystem::class);
    }
    public function salaryHistory(): HasMany
    {
        return $this->hasMany(SalaryHistory::class);
    }

    public function supplier(): HasMany
    {
        return $this->hasMany(Supplier::class);
    }
    public function expense(): HasMany
    {
        return $this->hasMany(Expense::class);
    }
    public function paymentMethod(): HasMany
    {
        return $this->hasMany(PaymentMethod::class);
    }
    public function paymentHistory(): HasMany
    {
        return $this->hasMany(PaymentHistory::class);
    }
    public function invoiceCategory(): HasMany
    {
        return $this->hasMany(InvoiceCategory::class);
    }
    public function invoicePay(): HasMany
    {
        return $this->hasMany(InvoicePay::class);
    }
    public function income(): HasMany
    {
        return $this->hasMany(Income::class);
    }
    public function client(): HasMany
    {
        return $this->hasMany(Client::class);
    }
    public function cashier(): HasMany
    {
        return $this->hasMany(Cashier::class);
    }
    public function operatorCashier(): HasMany
    {
        return $this->hasMany(OperatorCashier::class);
    }
    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }
    public function sale(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
