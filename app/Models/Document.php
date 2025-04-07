<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasUlids;

    protected $fillable = [
        'name',
        'disposition',
        'content',
        'options',
    ];

    protected $casts = [
        'content' => 'array',
        'options' => 'array',
    ];

    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}
