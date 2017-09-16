<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    //

    public function __invoke()
    {
        // TODO: Implement __invoke() method.
        $banner = [
            [
                'image_url' => url('banner_images/banner_herbal_app.jpg'),
                'label'     => 'banner herbal',
                'action'    => 'http://facebook.com'
            ],
            [
                'image_url' => url('banner_images/banner_makanan&minuman_app.jpg'),
                'label'     => 'banner Minuman dan Makanan',
                'action'    => 'http://google.com'
            ],
            [
                'image_url' => url('banner_images/banner_multivitamin_app.jpg'),
                'label'     => 'banner multivitamin',
                'action'    => 'http://aliflammim.id'
            ]

        ];
        return response()->json(['banner'=>$banner]);
    }
}
