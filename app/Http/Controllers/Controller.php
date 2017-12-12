<?php

namespace Closet\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Config;
use Session;
use App;
use Cookie;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function lang()
    {
        $locale = Config::get('closet.locale');
        $current = App::getLocale();
        return response()->json([
            'locale' => $locale,
            'current_locale' => $current
        ]);
    }

    public function langChange($lang)
    {
        \Session::put('locale', $lang);

        return response()->json(null, 200)->withCookie(cookie('locale', $lang, 999999));
    }

}
