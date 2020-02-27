<?php

namespace App;

use App\Events\CarBid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Car extends Model
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['latest_bid_amount'];

    /**
     * Get the bids for the car.
     */
    public function bids()
    {
        return $this->morphMany('App\Bid', 'biddable');
    }

    public function getLatestBidAttribute()
    {
        return $this->bids()->lockForUpdate()->latest()->first();
    }

    public function getLatestBidAmountAttribute()
    {
        return $this->bids()->exists() ? $this->latest_bid->amount : Bid::INITIAL;
    }

    public function bid()
    {
        $bid = new Bid;
        $bid->amount = $this->latest_bid_amount + Arr::random(Bid::INCREMENTS);

        $this->bids()->save($bid);

        event(new CarBid($this->load('bids'), $bid->load('bidder')));
    }
}
