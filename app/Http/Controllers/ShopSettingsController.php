<?php

namespace Closet\Http\Controllers;

use Image;
use Storage;
use Closet\Models\{Shop, Contact, Account};
use Closet\Http\Requests;
use Illuminate\Http\Request;
use Closet\Http\Requests\ShopUpdateRequest;
use Closet\Jobs\ShopImage\{UploadCover, UploadThumbnail};
use Closet\Jobs\Images\DeleteImage;

class ShopSettingsController extends Controller
{
    public function edit(Shop $shop)
    {
      $this->authorize('edit', $shop);

      return view('shop.settings.edit' , [
        'shop' => $shop
      ]);
    }

    public function update(ShopUpdateRequest $request, Shop $shop)
    {
      $this->authorize('update', $shop);

      $shop->update([
        'name' => $request->name,
        'slug' => $request->slug,
        'description' => $request->description,
      ]);

      return response()->json();
    }
    public function updateThumbnail(Request $request, Shop $shop)
    {
      if (!empty($shop->thumbnail)) {
      $path = 'profile/thumbnail/'.$shop->thumbnail;
      $this->dispatch(new DeleteImage($path));
      }
      $thumbnail = $request->thumbnail;
      $fileName = uniqid('profile_thumb_'.$request->user()->id);

      $this->dispatch(new UploadThumbnail($shop, $thumbnail, $fileName));
      return response()->json(null, 200);
    }

    public function updateCover(Request $request, Shop $shop)
    {
      if (!empty($shop->cover)) {
      $path = 'profile/cover/'.$shop->cover;
      $this->dispatch(new DeleteImage($path));
      }

        $cover = $request->cover;
        $fileName = uniqid('cov_'.$request->user()->id);
        $this->dispatch(new UploadCover($shop, $cover, $fileName));
    }

    public function getContact(Request $request, Shop $shop)
    {
      $contacts = $shop->contact()->get();

      return response()->json($contacts);
    }

    public function createContact(Request $request,Shop $shop)
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

    public function updateContact(Request $request, Shop $shop, Contact $contact)
    {
      $this->validate($request, ['link' => 'url',]);
      if($request->body !== null){
        $contact->update(['body' => $request->body]);
      } elseif($request->link !== null) {
        $contact->update(['link' => $request->link]);
      }
      return ;
    }

    public function deleteContact(Request $request, Shop $shop, Contact $contact)
    {
      $contact->delete();

      return response()->json(null, 200);
    }

    public function toggleShowProduct(Request $request, Shop $shop, Contact $contact)
    {
      if($contact->show_product == true) {
          $update = $contact->update([
            'show_product' => false,
          ]);
      } else {
          $update = $contact->update([
            'show_product' => true,
        ]);
      }
      return response()->json($contact);
    }

    public function toggleShowCover(Request $request, Shop $shop, Contact $contact)
    {
      if($contact->show_cover == true) {
          $contact->update(['show_cover' => false]);
      } else {
          $contact->update(['show_cover' => true]);
      }
      return ;
    }

    public function getAccounts(Shop $shop)
    {
      $accounts = $shop->account;
      return response()->json($accounts);
    }

    public function addAccount(Request $request, Shop $shop)
    {
        $data = $request->number;
        $number = substr($data, 0, 3) .' - '. substr($data, 3, 1) .' - '. substr($data, 4, 5).' - '. substr($data, 9);
        if(!$request->user()->can_sell) {
          $request->user()->can_sell = true;
          $request->user()->save();
        }
      $create = $shop->account()->create([
        'provider_name' => $request->provider['name'],
        'provider' => $request->provider['code'],
        'name' => $request->name,
        'number' => $number,
      ]);
      return response()->json($create);
    }

    public function removeAccount(Shop $shop, Account $account)
    {
      $account->delete();
      return;
    }

    public function setSellStatus(Shop $shop)
    {
      $shop->user()->update([
        'can_sell' => false
      ]);
      return;
    }
}
