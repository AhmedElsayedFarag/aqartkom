<?php

namespace Modules\Auction\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuctionView extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'auction_id'];
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function auction(){
        return $this->belongsTo(Auction::class);
    }
}
