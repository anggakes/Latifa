<?php

namespace App\Http\Controllers\PushNotification;

use App\Models\Notification\PushNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PushNotificationController extends Controller
{
    //

    public function register(PushNotification $pnModel, Request $request)
    {


        $pn = $pnModel->firstOrCreate(['deviceId' => $request->deviceId]);
        $pn->userId = $request->userId;
        $pn->playerId = $request->playerId;
        $pn->deviceName = $request->deviceName;
        $pn->role = $request->role;
        $pn->save();

        return $pn;

    }

    public function unRegister(PushNotification $pnModel, Request $request){

        $pn = $pnModel->where('deviceId', $request->deviceId);
        $pn->delete();

        return $pn;

    }


}
