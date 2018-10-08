<?php

namespace Closet\Http\Controllers\Shop\Settings;

use Closet\Models\{Shop, Account};
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;

class AccountController extends Controller
{
  public function get(Request $request)
  {
    $accounts = $request->user()->account;
    return response()->json($accounts);
  }

  public function create(Request $request)
  {
    $data = $request->number;
    if ($request->type == 'account') {
      $number = substr($data, 0, 3) .' - '. substr($data, 3, 1) .' - '. substr($data, 4, 5).' - '. substr($data, 9);
    } else {
      $number = $data;
    }

    $create = $request->user()->account()->create([
      'shop_id' => $request->user()->shop->id,
      'provider_name' => $request->provider['name'],
      'provider' => $request->provider['code'],
      'name' => $request->name,
      'number' => $number,
      'type' => $request->type,
    ]);

    return response()->json($create);
  }

  public function delete(Account $account)
  {
    $account->delete();
    return;
  }

}
