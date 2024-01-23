<?php

namespace Modules\BotQuestion\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BotQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'type',
        'content',
    ];
}