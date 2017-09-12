<?php

namespace App\Http\Controllers;

use Request;
class DcController extends Controller
{
    //
    public function index($type)
    {
        return view("dc.{$type}");
    }

}
