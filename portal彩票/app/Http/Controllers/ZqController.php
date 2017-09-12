<?php

namespace App\Http\Controllers;

use Request;
class ZqController extends Controller
{
    //
    public function index($type)
    {
        return view("zq.{$type}");
    }

}
