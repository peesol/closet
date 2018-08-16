<?php

Auth::routes();

Route::get('register/verify/{token}', 'Auth\RegisterController@verify');
Route::get('register/email/resend', 'Auth\RegisterController@resendEmailPage')->name('resendEmail');
Route::post('register/email/resend', 'Auth\RegisterController@resendEmail')->name('resendEmailPost');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/shops', 'HomeController@shops')->name('shops');
Route::get('/trending', 'HomeController@trending')->name('trending');
Route::get('/secondhand', 'HomeController@secondhand')->name('secondhand');

Route::get('/locale_ajax', 'Language\LanguageController@getLanguage');
Route::put('/locale_ajax/{lang}', 'Language\LanguageController@languageChange');

//Route::get('/search/by/{keyword}', 'SearchController@searchByProduct');
Route::get('/search/result', 'Search\SearchController@index')->name('result');
Route::get('/search/result/products', 'Search\SearchController@productResult');

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

/*
|--------------------------------------------------------------------------
| Help center route
|--------------------------------------------------------------------------
*/
Route::get('/help/home', 'Help\TutorialController@homePage')->name('helpHome');
Route::get('/help/ask', 'Help\TutorialController@askPage')->name('askPage');
Route::post('/help/ask', 'Help\TutorialController@askPost')->name('askPost');
//seller
Route::get('/help/seller/home', 'Help\Seller\SellerGuideController@index')->name('sellerGuide');
//buyer
Route::get('/help/buyer/home', 'Help\Buyer\BuyerGuideController@index')->name('buyerGuide');
/*
|--------------------------------------------------------------------------
| Admin route
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['admin']], function () {
  Route::get('/secret/admin/home', 'Admin\AdminController@homePage')->name('adminHome');
  Route::get('/secret/admin/banner', 'Admin\Banner\BannerController@index')->name('bannerAdmin');
  Route::post('/secret/admin/banner/add', 'Admin\Banner\BannerController@create');
  Route::get('/secret/admin/banner/edit/{banner}', 'Admin\Banner\BannerController@edit');
  Route::put('/secret/admin/banner/edit/{banner}', 'Admin\Banner\BannerController@update')->name('bannerUpdate');
  Route::delete('/secret/admin/banner/edit/{banner}/delete', 'Admin\Banner\BannerController@delete');

  Route::get('/secret/admin/products', 'Admin\Product\CompanyProductController@index')->name('productAdmin');
  Route::get('/secret/admin/reports', 'Admin\Report\ReportController@index')->name('reportsAdmin');
  Route::delete('/secret/admin/reports/delete', 'Admin\Report\ReportController@delete')->name('reportDelete');
});

/*
|--------------------------------------------------------------------------
| Utillity Api
|--------------------------------------------------------------------------
*/
Route::get('/api/getter/shop/{id}', 'Api\Getter@getShop');

/*
|--------------------------------------------------------------------------
| Report Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth']], function () {
  Route::get('/report/product/{product}', 'Report\ReportController@productView');
  Route::get('/report/shop/{shop}', 'Report\ReportController@shopView')->name('shopReportView');
  Route::post('/report/product/{product}/sending', 'Report\ReportController@productCreate')->name('productReport');
  Route::post('/report/shop/{shop}/sending', 'Report\ReportController@shopCreate')->name('shopReport');
  Route::get('/report/success', 'Report\ReportController@success')->name('reportSuccess');
});

/*
|--------------------------------------------------------------------------
| Collection Routes
|--------------------------------------------------------------------------
*/

//Collection Page
Route::get('/collection_api/{shop}', 'Collection\CollectionController@get');
Route::get('/collection_api/img/{collection}', 'Collection\CollectionController@getPhoto');
Route::get('/collection_api/products/{collectionId}', 'Collection\CollectionController@getProduct');
Route::get('/collection/{collection}', 'Collection\CollectionController@show');

Route::group(['middleware' => ['auth']], function () {
  Route::post('/collection_api/{shop}', 'Collection\CollectionController@create');
  Route::delete('/collection/{collection}', 'Collection\CollectionController@delete');

  //Collection Edit Routes
  Route::get('/collection/{collection}/edit', 'Collection\CollectionEditController@edit');
  Route::put('/collection/{collection}/edit', 'Collection\CollectionEditController@update');

  Route::post('/collection/{collection}/upload/{id}', 'Collection\CollectionEditController@uploadPhoto');
  Route::delete('/collection/image/{id}', 'Collection\CollectionEditController@deletePhoto');
  Route::get('/collection/image/{id}', 'Collection\CollectionEditController@photo');
  Route::delete('/collection/{collectionId}/delete/{productId}', 'Collection\CollectionEditController@deleteProduct');

  // Add to collection api
  Route::get('/collection_api/{shop}/add/{productId}', 'Collection\Api\AddController@getAddedProduct');
  Route::post('/collection/{collectionId}/add/{productId}', 'Collection\Api\AddController@create');

});

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
/**BUYER**/
Route::get('/order/{order}/transaction_email', 'Order\EmailController@transactionPage');
Route::put('/order/{order}/transaction_email', 'Order\EmailController@transactionConfirm');
Route::get('/order/{order}/cancle_email', 'Order\EmailController@canclePage');
Route::put('/order/{order}/cancle_email', 'Order\EmailController@cancle');

/**SELLER**/
Route::get('/order/{order}/shipped_email', 'Order\EmailController@shippedPage');
Route::put('/order/{order}/shipped_email', 'Order\EmailController@confirmShipping');
Route::get('/order/{order}/deny_email', 'Order\EmailController@denyPage');
Route::put('/order/{order}/deny_email', 'Order\EmailController@deny');

/*
|--------------------------------------------------------------------------
| Order via Site with auth middleware
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth']], function () {
  Route::get('/profile/order/selling/get', 'Order\OrderController@getSellingInbox');
  Route::get('/profile/order/buying/get', 'Order\OrderController@getBuyingInbox');

  Route::get('/profile/order/selling/history', 'Order\OrderController@sellingHistoryPage');
  Route::get('/profile/order/buying/history', 'Order\OrderController@buyingHistoryPage');
  Route::get('/profile/order/selling/history/get', 'Order\OrderController@getSellingHistory');
  Route::get('/profile/order/buying/history/get', 'Order\OrderController@getBuyingHistory');

  Route::post('/order/sending', 'Order\OrderController@store');
  Route::get('/profile/order/selling', 'Order\OrderController@sellingPage')->name('sellingOrder');
  Route::get('/profile/order/buying', 'Order\OrderController@buyingPage')->name('buyingOrder');
  Route::put('/profile/order/{order}/transaction', 'Order\OrderController@transactionConfirm');
  Route::put('/profile/order/{order}/confirm_shipping', 'Order\OrderController@confirmShipping');

  Route::put('/order/{order}/deny', 'Order\OrderController@deny');
});


Route::group(['middleware' => ['auth']], function () {


    Route::prefix('profile')->group(function () {
      Route::get('/mycollection', 'Collection\CollectionController@index')->name('myCollection');
      Route::get('/following', 'FollowingController@index')->name('following');

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

    }); //End profile prefix

/*
|--------------------------------------------------------------------------
| Product Routes
|--------------------------------------------------------------------------
*/
//Product Sell
  Route::namespace('Product\Sell')->group(function () {
    Route::get('/sell/new', 'NewProductController@index');
    Route::post('/sell/new', 'NewProductController@create');
    Route::get('/sell/new/after', 'NewProductController@after');
    Route::get('/sell/used', 'UsedProductController@index');
    Route::post('/sell/used', 'UsedProductController@create');
  });
//Product Delete
  Route::delete('/product/used/{product}', 'Product\DeleteController@deleteUsedProduct');
  Route::delete('/product/{product}', 'Product\DeleteController@deleteNewProduct');
  //Comments
  Route::post('/product/{product}/comments', 'ProductCommentController@create');
  Route::delete('/product/{product}/comments/{comment}', 'ProductCommentController@delete');
  //Votes
  Route::post('/product/{product}/votes', 'ProductVoteController@create');
  Route::delete('/product/{product}/votes', 'ProductVoteController@delete');
/*
|--------------------------------------------------------------------------
| Product Edit Routes
|--------------------------------------------------------------------------
*/
  Route::get('/product/{product}/edit', 'Product\Edit\UpdateController@index')->name('productEdit');
  Route::put('/product/{product}/edit', 'Product\Edit\UpdateController@update');
  //Photo Upload & Delete
  Route::get('/product/{product}/get_photo', 'Product\Photo\PhotoController@get');
  Route::post('/product/{product}/upload_photo', 'Product\Photo\PhotoController@upload');
  Route::delete('/product/delete_photo/{photo_id}', 'Product\Photo\PhotoController@delete')->name('productDelete');
  //Choices
  Route::get('/product/{product}/get_choice', 'Product\Choice\ChoiceController@get');
  Route::post('/product/{product}/create', 'Product\Choice\ChoiceController@create');
  Route::put('/product/{product}/toggle_choice', 'Product\Choice\ChoiceController@toggle');
  Route::delete('/product/{product}/choice/delete/{id}', 'Product\Choice\ChoiceController@remove');
/*
|--------------------------------------------------------------------------
| Note Routes
|--------------------------------------------------------------------------
*/
  Route::get('/profile/note', 'User\NoteController@index');
  Route::post('/profile/note/add', 'User\NoteController@create');

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
  Route::get('/profile/myproduct/shipping', 'Shop\Settings\ShippingController@index');
  Route::put('/profile/myproduct/shipping/update', 'Shop\Settings\ShippingController@update');

  Route::post('/product/used/{product}/comments', 'UsedCommentController@create');
  Route::delete('/product/used/{product}/comments/{comment}', 'UsedCommentController@delete');

  Route::post('/follow/{shop}', 'ShopFollowController@create');
  Route::delete('/follow/{shop}', 'ShopFollowController@delete');

    // Route::get('/test/upload', 'Test\Test@index');
    // Route::post('/test/upload/test', 'Test\Test@upload');
}); //End auth middleware
/*
|--------------------------------------------------------------------------
| Shop Routes
|--------------------------------------------------------------------------
*/
Route::namespace('Shop')->group(function () {
  Route::get('/{shop}', 'ShopController@index');
  Route::get('/{shop}/products', 'ShopController@product');
  Route::get('/{shop}/collection', 'ShopController@collection');
  Route::get('/{shop}/about', 'ShopController@about');
  Route::get('/{shop}/reviews', 'ShopController@review');
  Route::get('/{shop}/status', 'ShopController@getStatus');
  Route::put('/{shop}/views', 'ShopController@logView');
  // Shop Votes
  Route::get('/{shop}/votes', 'VoteController@get');
  Route::post('/{shop}/votes', 'VoteController@create');
  Route::delete('/{shop}/votes', 'VoteController@delete');
  //shop Reviews
  Route::get('/{shop}/reviews/get', 'ReviewController@get');
  Route::get('/{shop}/reviews/total', 'ReviewController@getTotalReview');
  Route::post('/{shop}/reviews', 'ReviewController@create');
  //Route::delete('/{shop}/reviews/delete/{feedback}', 'ReviewController@delete');


});
/*
|--------------------------------------------------------------------------
| Shop Edit Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth']], function () {

  Route::get('/{shop}/edit/general', 'Shop\Settings\ShopEditController@index');
  Route::get('/{shop}/edit/general/get', 'Shop\Settings\ShopEditController@getUserInfomation');
  Route::get('/{shop}/edit/contact', 'Shop\Settings\ShopEditController@index');
  Route::get('/{shop}/edit/account', 'Shop\Settings\ShopEditController@index');
  Route::get('/{shop}/edit/showcase', 'Shop\Settings\ShopEditController@index');
  Route::put('/{shop}/edit/public_info', 'Shop\Settings\ShopEditController@updatePublicInfo');
  Route::put('/{shop}/edit/personal_info', 'Shop\Settings\ShopEditController@updatePrivateInfo');
  Route::put('/{shop}/edit/cover', 'Shop\Settings\ShopEditController@updateCover');
  Route::put('/{shop}/edit/thumbnail', 'Shop\Settings\ShopEditController@updateThumbnail');

  Route::get('/{shop}/edit/contact/get', 'Shop\Settings\ContactController@get');
  Route::post('/{shop}/edit/contact', 'Shop\Settings\ContactController@create');
  Route::put('/{shop}/edit/contact/{contact}', 'Shop\Settings\ContactController@update');
  Route::delete('/{shop}/edit/contact/{contact}/delete', 'Shop\Settings\ContactController@delete');
  Route::put('/{shop}/edit/contact/{contact}/show', 'Shop\Settings\ContactController@toggleShow');


  Route::get('/{shop}/edit/account/get', 'Shop\Settings\AccountController@get');
  Route::post('/{shop}/edit/account', 'Shop\Settings\AccountController@create');
  Route::delete('/{shop}/edit/account/{account}/delete', 'Shop\Settings\AccountController@delete');

  /*
  |--------------------------------------------------------------------------
  | Showcases Routes
  |--------------------------------------------------------------------------
  */
  Route::get('/{shop}/edit/showcase/get', 'Showcase\ShowcaseController@get');
  Route::post('/{shop}/edit/showcase/create', 'Showcase\ShowcaseController@create');
  Route::put('/{shop}/edit/showcase/order/update', 'Showcase\ShowcaseController@updateOrder');
  Route::delete('/{shop}/edit/showcase/{showcase}/delete', 'Showcase\ShowcaseController@remove');
  Route::put('/{shop}/edit/showcase/{showcase}/toggle_show', 'Showcase\ShowcaseController@showOption');
  //Showcase Edit
  Route::get('/{shop}/edit/showcase/{showcase}/edit', 'Showcase\ShowcaseEditController@index');
  Route::get('/{shop}/edit/showcase/{showcase}/get_product', 'Showcase\ShowcaseEditController@getProduct');
  Route::post('/{shop}/edit/showcase/{showcase}/add_product/{id}', 'Showcase\ShowcaseEditController@storeProduct');
  Route::put('/{shop}/edit/showcase/{showcase}/update', 'Showcase\ShowcaseEditController@update');

});

Route::get('/test/cat', 'Test\TestController@test');
