<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdView extends Model
{
    use HasFactory;
    protected $fillable = ['ad_id', 'ip'];
    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }
}