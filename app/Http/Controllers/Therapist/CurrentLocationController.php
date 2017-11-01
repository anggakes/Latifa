<?php
/**
 * Created by PhpStorm.
 * User: anggakes
 * Date: 11/1/17
 * Time: 2:18 PM
 */

namespace App\Http\Controllers\Therapist;


use App\Http\Controllers\Controller;
use App\Models\Therapist\CurrentLocation;
use Illuminate\Http\Request;

class CurrentLocationController extends Controller
{

    public function __invoke(Request $request, CurrentLocation $currentLocation)
    {
        $currentLocation = $currentLocation->firstOrCreate(['userId' => auth()->user()->id]);

        $currentLocation->lat = $request->lat;
        $currentLocation->lng = $request->lng;

        $currentLocation->save();

        return response()->json($currentLocation);

    }

}