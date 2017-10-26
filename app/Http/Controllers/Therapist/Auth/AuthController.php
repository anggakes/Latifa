<?php

namespace App\Http\Controllers\Therapist\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    //

    public function __invoke(){

        return view('customer/auth');
    }

}
