<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    const INCREMENTS = [100, 300, 500];
    const INITIAL = 1000;

    public static function boot() {
        parent::boot();
    
        static::creating(function (Bid $bid) {
            $bid->user_id = auth('api')->user()->id;
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['amount'];

    /**
     * Get the owning biddable model.
     */
    public function biddable()
    {
        return $this->morphTo();
    }

    /**
     * Get the bidder.
     */
    public function bidder()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
