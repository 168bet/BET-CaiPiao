<?php

namespace App\Http\Controllers;

use Request;
class BuyController extends Controller
{
    //
    public function buy($slug)
    {
        return view("buy_{$slug}");
    }
    
    public function tz($type) {
        $data = Request::all();
    	return $data;
    }
}
