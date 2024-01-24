<?php

namespace App\Models;

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
}
