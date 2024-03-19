<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dummy(){
        $a=5;
        $b=0;
        $c=$a+$b;
        echo $c;
    }
}