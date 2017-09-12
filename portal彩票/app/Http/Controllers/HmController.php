<?php

namespace App\Http\Controllers;

use Request;
class HmController extends Controller
{
    public function index($type)
    {
        return view("hm.{$type}");
    }

}
