<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LotteryOrder extends Model
{
    //
    function lottery(Lottery $setLottery) {
    	if ($setLottery) {
    		$this->belongsTo('App\Lottery')->associate($setLottery);
    	}
    	else {
    		return $this->belongsTo('App\Lottery');
    	};
    }
    
    function user(User $setUser) {
    	if ($setUser) {
    		$this->belongsTo('App\User')->associate($setUser);
    	}
    	else {
    		return $this->belongsTo('App\User');
    	};
    }
}
