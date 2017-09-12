<?php

namespace App\Http\Controllers;

use Request;
class CartController extends Controller
{
    //
    public function index($type)
    {
        return view("cart.{$type}");
    }

}
