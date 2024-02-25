<?php
namespace App\Models\Financial;

use App\Models\Company;
use App\Facade\MoneyConvert;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/** Planos do sistema */
class PaymentPlan extends Model
{

    use HasFactory, SoftDeletes;
    protected $guarded = [];
    /** =============================MUTATORS================================ */
    public function permissions(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => json_decode($value) ,
        );
    }
    /** ============================ Relationship =============================*/
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    public function user(): HasMany
    {
        return $this->hasMany(Company::class);
    }
    /**============================================METODOS ESTATICOS================================================*/
    public static function read(bool $changeMoney = false)
    {
        $data = null;
        if($changeMoney){
            $data = PaymentPlan::get()->map(function ($value) {
                $value->price = MoneyConvert::getDbMoney($value->price);
                return $value;
            });
        }else{
            $data =  PaymentPlan::cursor();
        }
        return $data;
    }
}
