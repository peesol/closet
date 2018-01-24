<?php

Auth::routes();

Route::get('register/verify/{token}', 'Auth\RegisterController@verify');
Route::get('register/email/resend', 'Auth\RegisterController@resendEmailPage')->name('resendEmail');
Route::post('register/email/resend', 'Auth\RegisterController@resendEmail')->name('resendEmailPost');

Route::get('/', 'HomeController@index');
Route::get('/shops', 'HomeController@shops');
Route::get('/trending', 'HomeController@trending');

Route::get('/locale_ajax', 'Controller@lang');
Route::put('/locale_ajax/{lang}', 'Controller@langChange');

Route::get('/search/by/{keyword}', 'SearchController@searchByProduct');
Route::get('/search/result', 'SearchController@index')->name('result');
Route::get('/search/result/products', 'SearchController@productResult');

Route::prefix('product')->group(function () {
  Route::get('/{product}', 'ProductController@show');
  Route::get('/{product}/get', 'ProductController@productAjax');
  Route::get('/{product}/get_choice', 'ProductController@choiceAjax');
  Route::get('/{product}/votes', 'ProductVoteController@show');
  Route::get('/{product}/views', 'ProductController@viewCount');
  Route::put('/{product}/views', 'ProductController@logView');
  Route::get('/{product}/comments', 'ProductCommentController@index');
});


Route::get('/product/used/{product}', 'UsedController@show');
Route::get('/product/used/{product}/comments', 'UsedCommentController@index');

Route::get('/category_ajax/get_category', 'ProductController@getCategory');
Route::get('/category_ajax/get_subcategory/{categoryId}', 'ProductController@getSubcategory');
Route::get('/category_ajax/get_type/{subcategoryId}', 'ProductController@getType');
Route::get('/category/main', 'CategoryController@main')->name('categoryMain');
Route::get('/category/{category}', 'CategoryController@category');


Route::get('/{shop}', 'ShopController@index');
Route::get('/{shop}/products', 'ShopController@product');
Route::get('/{shop}/collection', 'ShopController@collection');
Route::get('/{shop}/about', 'ShopController@about');
Route::get('/{shop}/votes', 'ShopVoteController@show');
Route::get('/{shop}/status', 'ShopController@ajaxStat');
Route::put('/{shop}/views', 'ShopController@logView');

Route::get('/follow/{shop}', 'ShopFollowController@show');

Route::get('/collection_ajax/{shop}', 'CollectionController@collectionAjax');
Route::get('/collection_ajax/img/{collection}', 'CollectionController@getPhoto');
Route::get('/collection_ajax/products/{collectionId}', 'CollectionController@getProduct');
Route::get('/collection/{collection}', 'CollectionController@index');

Route::prefix('cart')->group(function () {
  Route::get('/get', 'CartController@getCart');
  Route::get('/get_product/{product}', 'CartController@getProduct');
  Route::get('/get_shop', 'CartController@getCartByShop');
  Route::post('/add/{product}', 'CartController@addToCart');
  Route::put('/update/qty', 'CartController@updateQty');
  Route::put('/remove/{rowId}', 'CartController@removeProduct');
  Route::get('/mycart', 'CartController@userCart');
});


// Order via Email
Route::get('/order/{order}/confirm', 'OrderController@confirmPage');
Route::put('/order/{order}/confirm', 'OrderController@confirm');

Route::get('/order/{order}/shipped_email', 'OrderController@shippedPage');
Route::put('/order/{order}/shipped_email', 'OrderController@confirmShippingEmail');

Route::get('/order/confirmed_page', 'OrderController@confirmedPage');
Route::delete('/order/{order}/deny_email', 'OrderController@denyEmail');
Route::get('/order/{order}/transaction_email', 'OrderController@transactionPage');
Route::put('/order/{order}/transaction_email', 'OrderController@transactionConfirmEmail');


Route::group(['middleware' => ['auth']], function () {

    Route::post('/order/sending', 'OrderController@store');

    Route::prefix('profile')->group(function () {
      Route::get('/following', 'FollowingController@index')->name('following');
      //AJAX
      Route::get('/inbox_messages/selling', 'OrderController@getSellingInbox');
      Route::get('/inbox_messages/buying', 'OrderController@getBuyingInbox');

      Route::get('/promotions/manage', 'PromotionController@index')->name('promotionEdit');
      Route::get('/promotions/manage/code', 'PromotionController@codePage')->name('promotionCode');
      Route::get('/promotions/manage/code_get', 'PromotionController@getCodes');
      Route::post('/promotions/manage/code', 'PromotionController@createCode');
      Route::delete('/promotions/manage/code/{discount}', 'PromotionController@removeCode');
      Route::post('/promotions/code/validate', 'PromotionController@validateCode');

      Route::get('/promotions/manage/discount', 'PromotionController@discountPage')->name('promotionDiscount');
      Route::get('/promotions/manage/discount/product', 'PromotionController@getProduct');
      Route::put('/promotions/manage/discount/{product}/add', 'PromotionController@applyDiscount');
      Route::put('/promotions/manage/discount/{product}/delete', 'PromotionController@removeDiscount');

      // Route::get('/promotions/manage/getanother', 'PromotionController@dealsPage')->name('promotionSale');

      Route::prefix('order')->group(function () {
        Route::get('/selling', 'OrderController@sellingPage')->name('sellingOrder');
        Route::get('/buying', 'OrderController@buyingPage')->name('buyingOrder');
        Route::delete('/{order}/deny', 'OrderController@deny');
        Route::put('/{order}/transaction', 'OrderController@transactionConfirm');
        Route::put('/{order}/confirm_shipping', 'OrderController@confirmShipping');
      });
      Route::prefix('myproduct')->group(function () {
        Route::get('/new', 'ProductController@userProduct');
        Route::get('/used', 'UsedController@userProduct');
        Route::get('/get', 'StockController@getProduct');
        Route::put('/stock/set_amount/{product}', 'StockController@setAmount');
        Route::get('/stock', 'StockController@index');
        Route::get('/options', 'ProductController@shippingIndex');
        Route::put('/options/{shop}/shipping', 'ProductController@shippingEditAll');
      });
    });

    Route::prefix('showcase_ajax')->group(function () {
      Route::get('/myproducts/{showcase}', 'ShowcaseController@getProduct');
      Route::post('/products/{productId}/showcase/{showcaseId}', 'ShowcaseController@storeProduct');
      Route::get('/{shop}/showcase', 'ShowcaseController@getShowcase');
      Route::post('/{shop}/showcase', 'ShowcaseController@store');
      Route::put('/update/{id}', 'ShowcaseController@update');
      Route::put('/update/all/order', 'ShowcaseController@updateOrder');
      Route::delete('/delete/{showcase}', 'ShowcaseController@remove');
      Route::put('/show/{showcase}', 'ShowcaseController@showOption');
    });

    Route::get('/profile/showcase/{showcase}/edit', 'ShowcaseController@edit');

    Route::prefix('product_ajax')->group(function () {
      Route::get('/{product}/img', 'ProductController@getPhoto');
      Route::post('/{id}/img', 'ProductController@uploadPhoto');
      Route::delete('/{id}/img', 'ProductController@deletePhoto');
      Route::get('/{productId}/choice', 'ProductController@getChoice');
      Route::post('/{productId}/choice', 'ProductController@addChoice');
      Route::put('/{productId}/choice', 'ProductController@toggleChoice');
      Route::delete('/delete/choice/{id}', 'ProductController@removeChoice');
    });

	Route::get('/product/{product}/edit', 'ProductController@edit');
	Route::put('/product/{product}/edit', 'ProductController@update');
	Route::put('/product/{product}/edit/shipping', 'ProductController@updateShipping');
	Route::delete('/product/{product}', 'ProductController@delete');

  Route::prefix('sell')->group(function () {
    Route::get('/product', 'ProductController@create');
    Route::get('/subcat/{id}','ProductController@ajaxSubcat');
    Route::post('/product', 'ProductController@store');
    Route::get('/used', 'UsedController@create');
    Route::post('/used', 'UsedController@store');
  });
  Route::delete('/product/used/{product}', 'UsedController@delete');

    Route::get('/{shop}/edit', 'ShopSettingsController@edit');
    Route::put('/{shop}/edit', 'ShopSettingsController@update');
    Route::put('/{shop}/edit/cover', 'ShopSettingsController@updateCover');
    Route::put('/{shop}/edit/thumbnail', 'ShopSettingsController@updateThumbnail');
    Route::put('/{shop}/edit/personal_info', 'ShopSettingsController@updateUserInfo');

    Route::get('/{shop}/edit/info', 'ShopSettingsController@getContact');
    Route::post('/{shop}/edit/info', 'ShopSettingsController@createContact');
    Route::put('/{shop}/edit/info/{contact}', 'ShopSettingsController@updateContact');
    Route::put('/{shop}/edit/info/{contact}/show_product', 'ShopSettingsController@toggleShowProduct');
    Route::put('/{shop}/edit/info/{contact}/show_cover', 'ShopSettingsController@toggleShowCover');
    Route::delete('/{shop}/edit/info/{contact}/delete', 'ShopSettingsController@deleteContact');

    Route::get('/{shop}/edit/account', 'ShopSettingsController@getAccounts');
    Route::post('/{shop}/edit/account', 'ShopSettingsController@addAccount');
    Route::delete('/{shop}/edit/account/{account}/delete', 'ShopSettingsController@removeAccount');
    Route::put('/{shop}/edit/set_sell_status', 'ShopSettingsController@setSellStatus');

    Route::post('/product/{product}/votes', 'ProductVoteController@create');
    Route::delete('/product/{product}/votes', 'ProductVoteController@delete');

    Route::post('/{shop}/votes', 'ShopVoteController@create');
    Route::delete('/{shop}/votes', 'ShopVoteController@delete');

    Route::post('/product/{product}/comments', 'ProductCommentController@create');
    Route::delete('/product/{product}/comments/{comment}', 'ProductCommentController@delete');

    Route::post('/product/used/{product}/comments', 'UsedCommentController@create');
    Route::delete('/product/used/{product}/comments/{comment}', 'UsedCommentController@delete');

    Route::post('/follow/{shop}', 'ShopFollowController@create');
    Route::delete('/follow/{shop}', 'ShopFollowController@delete');

    Route::post('/collection_ajax/{shop}', 'CollectionController@store');
    Route::delete('/collection/{collection}', 'CollectionController@delete');
    Route::get('/collection/{collection}/edit', 'CollectionController@edit');
    Route::put('/collection/{collection}/edit', 'CollectionController@updateInfo');

    Route::post('/collection/{collection}/upload/{id}', 'CollectionController@uploadPhoto');
    Route::delete('/collection/image/{id}', 'CollectionController@deletePhoto');
    Route::get('/collection/image/{id}', 'CollectionController@photo');

    Route::post('/collection/{collectionId}/add/{productId}', 'CollectionController@storeProduct');
    Route::delete('/collection/{collectionId}/delete/{productId}', 'CollectionController@deleteProduct');
    Route::get('/collection_ajax/{shop}/add/{productId}', 'CollectionController@getAddCollection');
});
