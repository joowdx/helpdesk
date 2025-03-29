<?php

namespace App\Models;

use App\Enums\PaperSize;
use App\Enums\ResponseDisposition;
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
        'addressee',
        'content',
        'margins',
        'size',
        'request_id',
        'user_id',
    ];

    protected $casts = [
        'content' => 'array',
        'margins' => 'array',
        'size' => PaperSize::class,
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

    public function disposition(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ResponseDisposition::tryFrom($value) ?? ResponseDisposition::OTHER,
        )->shouldCache();
    }

    public function attachment(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachable');
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
}
