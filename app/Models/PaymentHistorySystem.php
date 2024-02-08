<?php

namespace App\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/** Historico de pagamento do sistema, feito pelo usuario */
class PaymentHistorySystem extends Model
{
    use HasFactory;

    /** Relationship */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
