<?php

Auth::routes();

Route::get('register/verify/{token}', 'Auth\RegisterController@verify');

Route::get('/', 'HomeController@index');

Route::get('/locale_ajax', 'Controller@lang');
Route::put('/locale_ajax/{lang}', 'Controller@langChange');

Route::get('/search/by/{keyword}', 'SearchController@searchByProduct');
Route::get('/search/result', 'SearchController@index')->name('result');
Route::get('/search/result/products', 'SearchController@productResult');


Route::get('/product/{product}', 'ProductController@show');
Route::get('/product/{product}/get', 'ProductController@productAjax');
Route::get('/product/{product}/get_choice', 'ProductController@choiceAjax');
Route::get('/product/{product}/votes', 'ProductVoteController@show');
Route::get('/product/{product}/views', 'ProductController@viewCount');
Route::post('/product/{product}/views', 'ProductController@logView');
Route::get('/product/{product}/comments', 'ProductCommentController@index');

Route::get('/product/used/{product}', 'UsedController@show');
Route::get('/product/used/{product}/comments', 'UsedCommentController@index');

Route::get('/category_ajax/get_category', 'ProductController@getCategory');
Route::get('/category_ajax/get_subcategory/{categoryId}', 'ProductController@getSubcategory');
Route::get('/category_ajax/get_type/{subcategoryId}', 'ProductController@getType');
Route::get('/category/main', 'CategoryController@main');
Route::get('/category/{category}', 'CategoryController@category');


Route::get('/{shop}', 'ShopController@index');

Route::get('/{shop}/products', 'ShopController@product');
Route::get('/{shop}/collection', 'ShopController@collection');
Route::get('/{shop}/about', 'ShopController@about');
Route::get('/{shop}/votes', 'ShopVoteController@show');
Route::get('/{shop}/status', 'ShopController@ajaxStat');

Route::get('/follow/{shop}', 'ShopFollowController@show');

Route::get('/collection_ajax/{shop}', 'CollectionController@collectionAjax');
Route::get('/collection_ajax/img/{collection}', 'CollectionController@getPhoto');
Route::get('/collection_ajax/products/{collectionId}', 'CollectionController@getProduct');
Route::get('/collection/{collection}', 'CollectionController@index');

Route::get('/cart/get', 'CartController@getCart');
Route::get('/cart/get_product/{product}', 'CartController@getProduct');
Route::get('/cart/get_shop', 'CartController@getCartByShop');
Route::post('/cart/add/{product}', 'CartController@addToCart');
Route::put('/cart/update/qty', 'CartController@updateQty');
Route::put('/cart/remove/{rowId}', 'CartController@removeProduct');
Route::get('/cart/mycart', 'CartController@userCart');

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

    Route::get('/profile/following', 'FollowingController@index');
    Route::get('/profile/order/selling', 'OrderController@sellingPage');
    Route::get('/profile/order/buying', 'OrderController@buyingPage');
    Route::get('/profile/inbox_messages/selling', 'OrderController@getSellingInbox');
    Route::get('/profile/inbox_messages/buying', 'OrderController@getBuyingInbox');

    Route::delete('/order/{order}/deny', 'OrderController@deny');
    Route::put('/order/{order}/transaction', 'OrderController@transactionConfirm');
    Route::put('/order/{order}/confirm_shipping', 'OrderController@confirmShipping');

    Route::get('/profile/myproduct/new', 'ProductController@userProduct');
    Route::get('/profile/myproduct/used', 'UsedController@userProduct');
    Route::get('/profile/myproduct/get', 'StockController@getProduct');
    Route::put('/profile/myproduct/stock/set_amount/{product}', 'StockController@setAmount');
    Route::get('/profile/myproduct/stock', 'StockController@index');
    Route::get('/profile/myproduct/options', 'ProductController@shippingIndex');
    Route::put('/profile/myproduct/options/{shop}/shipping', 'ProductController@shippingEditAll');

    Route::get('/showcase_ajax/myproducts/{showcase}', 'ShowcaseController@getProduct');
    Route::post('/showcase_ajax/products/{productId}/showcase/{showcaseId}', 'ShowcaseController@storeProduct');
    Route::get('/showcase_ajax/{shop}/showcase', 'ShowcaseController@getShowcase');
    Route::post('/showcase_ajax/{shop}/showcase', 'ShowcaseController@store');
    Route::put('/showcase_ajax/update/{id}', 'ShowcaseController@update');
    Route::put('/showcase_ajax/update/all/order', 'ShowcaseController@updateOrder');
    Route::delete('/showcase_ajax/delete/{showcase}', 'ShowcaseController@remove');
    Route::put('/showcase_ajax/show/{showcase}', 'ShowcaseController@showOption');
    Route::get('/profile/showcase/{showcase}/edit', 'ShowcaseController@edit');

	Route::get('/product/{product}/edit', 'ProductController@edit');
	Route::put('/product/{product}/edit', 'ProductController@update');
	Route::put('/product/{product}/edit/shipping', 'ProductController@updateShipping');
	Route::delete('/product/{product}', 'ProductController@delete');

    Route::get('/product_ajax/{product}/img', 'ProductController@getPhoto');
    Route::post('/product_ajax/{id}/img', 'ProductController@uploadPhoto');
    Route::delete('/product_ajax/{id}/img', 'ProductController@deletePhoto');
    Route::get('/product_ajax/{productId}/choice', 'ProductController@getChoice');
    Route::post('/product_ajax/{productId}/choice', 'ProductController@addChoice');
    Route::put('/product_ajax/{productId}/choice', 'ProductController@toggleChoice');
    Route::delete('/product_ajax/delete/choice/{id}', 'ProductController@removeChoice');

	Route::get('/sell/product', 'ProductController@create');
	Route::get('/sell/subcat/{id}','ProductController@ajaxSubcat');
	Route::post('/sell/product', 'ProductController@store');

  Route::get('/sell/used', 'UsedController@create');
  Route::post('/sell/used', 'UsedController@store');
  Route::delete('/product/used/{product}', 'UsedController@delete');

    Route::get('/{shop}/edit', 'ShopSettingsController@edit');
    Route::put('/{shop}/edit', 'ShopSettingsController@update');
    Route::put('/{shop}/edit/cover', 'ShopSettingsController@updateCover');
    Route::put('/{shop}/edit/thumbnail', 'ShopSettingsController@updateThumbnail');

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

/*test */

Route::get('/search/filter/r', 'SearchController@index');
