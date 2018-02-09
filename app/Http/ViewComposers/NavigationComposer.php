<?php

namespace Closet\Http\ViewComposers;

use Auth;
use Illuminate\View\View;

class NavigationComposer
{
  public function compose(View $view)
  {
    if(!Auth::check()){
      return;
    } else {
      $view->with('shop', Auth::user()->shop->first());
    }

  }
}
