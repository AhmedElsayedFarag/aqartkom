<?php

namespace Modules\Ad\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdReport extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'email', 'description', 'ad_id'];

    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }
}