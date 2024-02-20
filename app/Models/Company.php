<?php

namespace App\Models;

use App\Models\User;
use App\Models\Client;
use App\Models\ERP\Sale;
use App\Models\ERP\Cashier;
use App\Models\ERP\Product;
use App\Models\ERP\Supplier;
use App\Models\OperatorCashier;
use App\Models\Financial\Income;
use App\Models\Financial\Expense;
use Illuminate\Support\Collection;
use App\Models\Financial\InvoicePay;
use App\Models\Financial\PaymentPlan;
use Illuminate\Support\LazyCollection;
use App\Models\Financial\PaymentMethod;
use App\Models\Financial\SalaryHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\Financial\PaymentHistory;
use App\Models\Financial\InvoiceCategory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Financial\PaymentHistorySystem;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Contracts\Database\Eloquent\Builder;
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
            get: function ($value, $attributes) {
                if (empty($attributes['logo'])) {
                    return null;
                } else {
                    return (object)[
                        'default' => Storage::url('company/brand_logo/' . $attributes['logo']),
                        'thumbmail' => Storage::url('company/brand_logo/thumbmail/' . $attributes['logo'])
                    ];
                }
            },
        );
    }
    public function active(): Attribute
     {
         return Attribute::make(
             get: fn ($value, $attributes) => filter_var($value, FILTER_VALIDATE_BOOLEAN)

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
    /** ============================ ESCOPOS =============================*/

    /** ==========================================METODOS ESTATICOS============================================= */
    public static function staticWcount(int $id, string $relation)
    {
        $company = Company::where('id', $id)->withCount($relation)->first()->toArray();
        return $company["{$relation}_count"];
    }
    /**
     * Retorna uma coleção de empresas que contem um responsável
     *
     * @return LazyCollection
     */
    public static function companiesWithResponsible(): LazyCollection
    {
        return Company::select('id', 'name')->whereHas('users', function ($query) {
            $query->where('responsible', 1);
        })->cursor();
    }
    /**
     * Retorna uma coleção de empresas que não contenham um responsável
     *
     * @return Collection
     */
    public static function companiesWithoutResponsible(): Collection
    {
        $companies = Company::select('id', 'name')->withCount([
            'users' => function (Builder $query) {
                $query->where('responsible', 1);
            }
        ])->get()->map(function ($company) {
            if ($company->users_count == 0) {
                return $company;
            }
        })->filter()->values();
        return $companies;
    }
    /** ==========================================METODOS============================================= */
    public function wcount(string $relation)
    {
        return self::staticWcount($this->id, $relation);
    }
}
