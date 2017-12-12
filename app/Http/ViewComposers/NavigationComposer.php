<?php

namespace Closet\Http\ViewComposers;

use Auth;
use App;
use Illuminate\View\View;
use Closet\Models\Translation;
use Closet\Models\Category;

class NavigationComposer
{
  public function compose(View $view)
  {
    if(App::getLocale() == 'en'){
      $view->with('categories', Category::all());
    }
    if(App::getLocale() == 'th'){
      $category = Translation::whereNotNull('category_id')->where('language', 'th')->get();
      $view->with('categories', $category);
    }
    if(!Auth::check()){
      return;
    } else {
      $view->with('shop', Auth::user()->shop->first());
    }

  }
}
