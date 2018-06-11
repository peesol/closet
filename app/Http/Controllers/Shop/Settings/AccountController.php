<?php

namespace Closet\Http\Controllers\Shop\Settings;

use Closet\Models\{Shop, Account};
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;

class AccountController extends Controller
{
  public function get(Shop $shop)
  {
    $accounts = $shop->account;
    return response()->json($accounts);
  }

  public function create(Request $request, Shop $shop)
  {
    $data = $request->number;
    $number = substr($data, 0, 3) .' - '. substr($data, 3, 1) .' - '. substr($data, 4, 5).' - '. substr($data, 9);

    $create = $shop->account()->create([
      'provider_name' => $request->provider['name'],
      'provider' => $request->provider['code'],
      'name' => $request->name,
      'number' => $number,
    ]);

    return response()->json($create);
  }

  public function delete(Shop $shop, Account $account)
  {
    $account->delete();
    return;
  }

}
