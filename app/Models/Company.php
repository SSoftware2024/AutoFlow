<?php

namespace App\Models;

use App\Models\ERP\Sale;
use App\Models\User;
use App\Models\Client;
use App\Models\Financial\Income;
use App\Models\ERP\Cashier;
use App\Models\Financial\Expense;
use App\Models\ERP\Product;
use App\Models\ERP\Supplier;
use App\Models\Financial\InvoicePay;
use App\Models\Financial\PaymentMethod;
use App\Models\Financial\SalaryHistory;
use App\Models\Financial\PaymentHistory;
use App\Models\Financial\InvoiceCategory;
use App\Models\OperatorCashier;
use App\Models\Financial\PaymentHistorySystem;
use App\Models\Financial\PaymentPlan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $appends = [
        'logo_url'
    ];
    /** =============================MUTATORS================================ */
    public function logoUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes){
                if(empty($attributes['logo'])){
                    return null;
                }else{
                    return (object)[
                        'default' => Storage::url('company/brand_logo/'.$attributes['logo']),
                        'thumbmail' => Storage::url('company/brand_logo/thumbmail/'.$attributes['logo'])
                    ];
                }
            },
        );
    }
    /** ============================ Relationship =============================*/
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

    /** ==========================================METODOS ESTATICOS============================================= */

    /** ==========================================METODOS============================================= */
}
