<?php

namespace App\Http\Controllers\Customer\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    //

    public function __invoke(){

        return view('customer/auth');
    }

}
