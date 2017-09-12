<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LotteryResult extends Model
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
}
