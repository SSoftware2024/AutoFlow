<?php
namespace App\Models\Financial;

use App\Facade\MoneyConvert;
use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/** Planos do sistema */
class PaymentPlan extends Model
{

    use HasFactory, SoftDeletes;
    protected $guarded = [];
    /** Relationship */
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
