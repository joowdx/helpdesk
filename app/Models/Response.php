<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Response extends Model
{
    use HasUlids;

    protected $fillable = [
        'code',
        'file',
        'content',
        'options',
        'hash',
        'submitted',
        'request_id',
        'user_id',
        'submitted_at',
    ];

    protected $casts = [
        'content' => 'array',
        'options' => 'array',
        'submitted_at' => 'datetime',
    ];

    public static function booted(): void
    {
        static::deleting(function (self $response) {
            $response->attachment->delete();
        });

        static::creating(function (self $response) {
            $faker = fake();

            do {
                $codes = collect(range(1, 10))->map(fn () => $faker->unique()->bothify('####??????'))->toArray();

                $available = array_diff($codes, self::whereIn('code', $codes)->pluck('code')->toArray());
            } while (empty($available));

            $response->code = reset($available);
        });
    }

    public function submitted(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->submitted_at !== null,
            set: fn (?bool $submitted) => ['submitted_at' => $submitted ? now() : null],
        );
    }

    public function attachment(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'signers')
            ->using(Signer::class)
            ->withTimestamps();
    }

    public function request(): BelongsTo
    {
        return $this->belongsTo(Request::class);
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}
