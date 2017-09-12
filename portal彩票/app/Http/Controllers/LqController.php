<?php

namespace App\Http\Controllers;

use Request;
class LqController extends Controller
{
    //
    public function index($type)
    {
        return view("lq.{$type}");
    }

}
