<?php

Auth::routes();

Route::get('register/verify/{token}', 'Auth\RegisterController@verify');
Route::get('register/email/resend', 'Auth\RegisterController@resendEmailPage')->name('resendEmail');
Route::post('register/email/resend', 'Auth\RegisterController@resendEmail')->name('resendEmailPost');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/shops', 'HomeController@shops')->name('shops');
Route::get('/trending', 'HomeController@trending')->name('trending');

Route::get('/locale_ajax', 'Language\LanguageController@getLanguage');
Route::put('/locale_ajax/{lang}', 'Language\LanguageController@languageChange');

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

Route::get('/follow/{shop}', 'ShopFollowController@show');

Route::get('/collection_ajax/{shop}', 'CollectionController@collectionAjax');
Route::get('/collection_ajax/img/{collection}', 'CollectionController@getPhoto');
Route::get('/collection_ajax/products/{collectionId}', 'CollectionController@getProduct');
Route::get('/collection/{collection}', 'CollectionController@index');

/*
|--------------------------------------------------------------------------
| Cart Routes
|--------------------------------------------------------------------------
*/
Route::namespace('Cart')->group(function () {
  Route::get('/cart/get', 'CartController@getCart');
  Route::get('/cart/get_product/{product}', 'CartController@getProduct');
  Route::get('/cart/get_shop', 'CartController@getCartByShop');
  Route::post('/cart/add/{product}', 'CartController@addToCart');
  Route::put('/cart/update/qty', 'CartController@updateQty');
  Route::put('/cart/remove/{rowId}', 'CartController@removeProduct');
  Route::get('/cart/mycart', 'CartController@userCart');
});


/*
|--------------------------------------------------------------------------
| Order via Email
|--------------------------------------------------------------------------
*/
Route::get('/order/{order}/confirm', 'Order\EmailController@confirmPage');
Route::put('/order/{order}/confirm', 'Order\EmailController@confirm');

Route::get('/order/{order}/shipped_email', 'Order\EmailController@shippedPage');
Route::put('/order/{order}/shipped_email', 'Order\EmailController@confirmShipping');

Route::get('/order/confirmed_page', 'Order\EmailController@confirmedPage');
Route::delete('/order/{order}/deny_email', 'Order\EmailController@deny');

Route::get('/order/{order}/transaction_email', 'Order\EmailController@transactionPage');
Route::put('/order/{order}/transaction_email', 'Order\EmailController@transactionConfirm');
/*
|--------------------------------------------------------------------------
| Order via Site with auth middleware
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth']], function () {
  Route::get('/profile/order/selling', 'Order\OrderController@sellingPage')->name('sellingOrder');
  Route::get('/profile/order/buying', 'Order\OrderController@buyingPage')->name('buyingOrder');
  Route::delete('/profile/order/{order}/deny', 'Order\OrderController@deny');
  Route::put('/profile/order/{order}/transaction', 'Order\OrderController@transactionConfirm');
  Route::put('/profile/order/{order}/confirm_shipping', 'Order\OrderController@confirmShipping');
});


Route::group(['middleware' => ['auth']], function () {

    Route::post('/order/sending', 'OrderController@store');

    Route::prefix('profile')->group(function () {
      Route::get('/mycollection', 'CollectionController@myCollection')->name('myCollection');
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

    });

      Route::get('/profile/showcase/{showcase}/edit', 'ShowcaseController@edit');

      Route::get('/showcase_ajax/myproducts/{showcase}', 'ShowcaseController@getProduct');
      Route::post('/showcase_ajax/products/{productId}/showcase/{showcaseId}', 'ShowcaseController@storeProduct');
      Route::get('/showcase_ajax/{shop}/showcase', 'ShowcaseController@getShowcase');
      Route::post('/showcase_ajax/{shop}/showcase', 'ShowcaseController@store');
      Route::put('/showcase_ajax/update/{id}', 'ShowcaseController@update');
      Route::put('/showcase_ajax/update/all/order', 'ShowcaseController@updateOrder');
      Route::delete('/showcase_ajax/delete/{showcase}', 'ShowcaseController@remove');
      Route::put('/showcase_ajax/show/{showcase}', 'ShowcaseController@showOption');

/*
|--------------------------------------------------------------------------
| Product Routes
|--------------------------------------------------------------------------
*/
//Product Sell
Route::namespace('Product\Sell')->group(function () {
  Route::get('/sell/new', 'NewProductController@index');
  Route::post('/sell/new', 'NewProductController@create');
  Route::get('/sell/used', 'UsedProductController@index');
  Route::post('/sell/used', 'UsedProductController@create');
});
//Product Delete
Route::delete('/product/used/{product}', 'Product\DeleteController@deleteUsedProduct');
Route::delete('/product/{product}', 'Product\DeleteController@deleteNewProduct');

/*
|--------------------------------------------------------------------------
| Product Edit Routes
|--------------------------------------------------------------------------
*/
Route::get('/product/{product}/edit', 'Product\Edit\UpdateController@index');
Route::put('/product/{product}/edit', 'Product\Edit\UpdateController@update');
//Shipping
Route::put('/product/{product}/edit/shipping', 'Product\Shipping\ShippingController@updateByProduct');
//Photo Upload & Delete
Route::get('/product/{product}/get_photo', 'Product\Photo\PhotoController@get');
Route::post('/product/{product}/upload_photo', 'Product\Photo\PhotoController@upload');
Route::delete('/product/delete_photo/{photo_id}', 'Product\Photo\PhotoController@delete');
//Choices
Route::get('/product/{product}/get_choice', 'Product\Choice\ChoiceController@get');
Route::post('/product/{product}/create', 'Product\Choice\ChoiceController@create');
Route::put('/product/{product}/toggle_choice', 'Product\Choice\ChoiceController@toggle');
Route::delete('/product/{product}/choice/delete/{id}', 'Product\Choice\ChoiceController@remove');
/*
|--------------------------------------------------------------------------
| My Product Routes
|--------------------------------------------------------------------------
*/
Route::get('/profile/myproduct/new', 'ProductController@userProduct');
Route::get('/profile/myproduct/used', 'UsedController@userProduct');
// get my product
Route::get('/profile/myproduct/get', 'Product\User\MyProductController@getProduct');
//Stock
Route::get('/profile/myproduct/stock', 'Product\Stock\StockController@index');
Route::put('/profile/myproduct/stock/set_amount/{product}', 'Product\Stock\StockController@update');
//Shipping edit for all products
Route::get('/profile/myproduct/shipping', 'Product\Shipping\ShippingController@index');
Route::put('/profile/myproduct/shipping/update', 'Product\Shipping\ShippingController@updateAll');


    Route::post('/product/{product}/comments', 'ProductCommentController@create');
    Route::delete('/product/{product}/comments/{comment}', 'ProductCommentController@delete');

    Route::post('/product/used/{product}/comments', 'UsedCommentController@create');
    Route::delete('/product/used/{product}/comments/{comment}', 'UsedCommentController@delete');

    Route::post('/product/{product}/votes', 'ProductVoteController@create');
    Route::delete('/product/{product}/votes', 'ProductVoteController@delete');

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

    // Route::get('/test/upload', 'Test\Test@index');
    // Route::post('/test/upload/test', 'Test\Test@upload');
});
/*
|--------------------------------------------------------------------------
| Shop Routes
|--------------------------------------------------------------------------
*/
Route::get('/{shop}', 'ShopController@index');
Route::get('/{shop}/products', 'ShopController@product');
Route::get('/{shop}/collection', 'ShopController@collection');
Route::get('/{shop}/about', 'ShopController@about');
Route::get('/{shop}/votes', 'ShopVoteController@show');
Route::get('/{shop}/status', 'ShopController@ajaxStat');
Route::put('/{shop}/views', 'ShopController@logView');

Route::group(['middleware' => ['auth']], function () {
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

  Route::post('/{shop}/votes', 'ShopVoteController@create');
  Route::delete('/{shop}/votes', 'ShopVoteController@delete');
});
