<?php

namespace Modules\Auth\Entities;

use Modules\Auth\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MarketerProfile extends Model
{
    use HasFactory;

    protected $fillable = ['whatsapp_number', 'advertisement_number', 'qr_code', 'city_id', 'advertisement_type'];

    /**
     * Get the user that owns the marketer profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
