<?php
/**
 * Created by PhpStorm.
 * User: anggakes
 * Date: 8/11/17
 * Time: 9:27 PM
 */

namespace App\Http\Controllers\CustomerFrontend;


class HomeController
{

    public function index(){

        return view('welcome');

    }

}