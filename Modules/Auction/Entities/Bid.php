<?php

namespace Modules\Auction\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Auction\Enums\BidStatusEnum;
use Modules\Auth\Entities\User;

class Bid extends Model
{
    use HasFactory;

    protected $fillable = ['phone', 'name', 'national_number', 'amount', 'total', 'user_id', 'auction_id', 'status'];

    protected static function newFactory()
    {
        return \Modules\Auction\Database\factories\BidFactory::new();
    }


    public static function boot()
    {
        parent::boot();

        static::created(
            function ($model) {
                if ($area = $model->auction->estate->area) {
                    $model->total = (float)$model->amount * $area;
                    $model->save();
                }
            }
        );
    }
    /**
     * Get the user associated with the bid.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the auction associated with the bid.
     */
    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }
    public function scopeStatus(Builder $query, string $status)
    {
        return $query->where('status', $status);
    }
    public function scopeUserFilter(Builder $query, int $userID)
    {
        return $query->where('user_id', $userID);
    }
}