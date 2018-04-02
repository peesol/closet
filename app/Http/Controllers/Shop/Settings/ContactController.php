<?php

namespace Closet\Http\Controllers\Shop\Settings;

use Illuminate\Http\Request;
use Closet\Models\{Shop, Contact};
use Closet\Http\Controllers\Controller;

class ContactController extends Controller
{
  public function get(Request $request, Shop $shop)
  {
    $contacts = $shop->contact()->get();

    return response()->json($contacts);
  }

  public function create(Request $request,Shop $shop)
  {
    $this->authorize('update', $shop);

    $this->validate($request, ['link' => 'sometimes|nullable|url']);

    $data = $shop->contact()->create([
      'shop_id' => $request->shop->id,
      'type' => $request->type,
      'body' => $request->body,
      'link' => $request->link,
    ]);
    return response()->json($data);
  }
  public function update(Request $request, Shop $shop, Contact $contact)
  {
    $this->validate($request, ['link' => 'url',]);
    if($request->body !== null){
      $contact->update(['body' => $request->body]);
    } elseif($request->link !== null) {
      $contact->update(['link' => $request->link]);
    }
    return ;
  }

  public function delete(Request $request, Shop $shop, Contact $contact)
  {
    $contact->delete();

    return response()->json(null, 200);
  }

  public function toggleShow(Request $request, Shop $shop, Contact $contact)
  {
    if($contact->show == true) {
      $update = $contact->update([ 'show' => false ]);
    } else {
      $update = $contact->update([ 'show' => true ]);
    }
    return response()->json($update);
  }
}
