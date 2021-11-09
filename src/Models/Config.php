<?php

namespace EscolaLms\Settings\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    public $table = 'config';

    public $incrementing = false;
    public $timestamps = false;

    public $fillable = [
        'id',
        'value',
    ];

    protected $casts = [
        'id' => 'integer',
        'value' => 'array',
    ];
}
