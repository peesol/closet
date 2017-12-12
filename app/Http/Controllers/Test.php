<?php

namespace Closet\Http\Controllers;

use Illuminate\Http\Request;
use Closet\Models\Collection;
use Closet\Models\CollectionImage;
use Closet\Models\Translation;
use Closet\Models\Category;
use Closet\Models\Shop;
use Closet\Http\Requests\CreateCollectionRequest;
use Closet\Transformer\CollectionTransformer;
use Lang;
use Config;
use Storage;
use Session;
use App;

class Test extends Controller
{

    public function edit(Collection $collection)
    {
    	return view('test.dropzone', [

        'collection' => $collection

      ]);     
      
    }

    public function upload(Request $request, Collection $collection)
    {
      foreach ($request->file('image') as $images) {
      	
          $fileId = uniqid('c_img_');
          
          $images->move(storage_path('uploads/collection/'), $fileId . '.jpg' );            
      }
    }

    public function translate(Category $category)
    {
        $category = $category->with(array('translateThai' => function($query){

          $query->select(['id', 'name', 'category_id']);

          }))->get();
      return dd(response()->json($category));
    } 

}
