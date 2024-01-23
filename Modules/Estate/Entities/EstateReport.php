<?php

namespace Modules\Estate\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EstateReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'estate_id',
        'description',
    ];
    public function estate(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Estate::class);
    }
}