<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Signer extends Pivot
{
    use HasUlids;

    protected $table = 'signers';

    public function response(): BelongsTo
    {
        return $this->belongsTo(Response::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
