<?php
/**
 * Created by PhpStorm.
 * User: anggakes
 * Date: 10/31/17
 * Time: 5:39 PM
 */

namespace App\Http\Controllers\Therapist;


use App\Http\Controllers\Controller;
use App\Models\Therapist\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{


    public function setOrder(Request $request, Settings $settings){

        $switch = $request->switch;
        $settings = $settings->firstOrCreate(['userId' => auth()->user()->id]);
        $settings->activeOrder = $switch;
        $settings->save();

        return response()->json(['activeOrder' => $settings->activeOrder]);
    }

    public function getOrder(Request $request, Settings $settings){

        $settings = $settings->where(['userId' => auth()->user()->id])->first();

        return response()->json(['activeOrder' => $settings->activeOrder]);
    }

}