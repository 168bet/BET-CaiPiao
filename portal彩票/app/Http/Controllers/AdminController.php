<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LotteryResult;
use App\Lottery;

class AdminController extends Controller
{
    //
    function resultUpdate(Request $request ,$slug) {
    	$lottery = Lottery::where('slug', $slug)->firstOrFail();
    	
    	if ($lottery) {
	    	$result = new LotteryResult();
	    	$result->lottery($lottery);
	    	$result->key = $request->get('key');
	    	$result->phase = $request->get('phase');
	    	$result->save();
	    	
	    	return 'done';
    	}
    	return 'error';
    }
}
