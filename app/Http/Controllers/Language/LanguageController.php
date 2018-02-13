<?php

namespace Closet\Http\Controllers\Language;
use App;
use Config;
use Session;
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;

class LanguageController extends Controller
{
  public function getLanguage()
  {
      $locale = Config::get('closet.locale');
      $current = App::getLocale();
      return response()->json([
          'locale' => $locale,
          'current_locale' => $current
      ]);
  }

  public function languageChange($lang)
  {
      \Session::put('locale', $lang);

      return response()->json(null, 200)->withCookie(cookie('locale', $lang, 999999));
  }
}
