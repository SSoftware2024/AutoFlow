<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/** Tipo do cliente */
class TypeClient extends Model
{
    use HasFactory;
    /** Relationship */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
