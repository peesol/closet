<?php

Auth::routes();

Route::get('register/success', 'Auth\RegisterController@success')->name('successRegister');
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


Route::get('/product/{product}', 'Product\Show\NewProductShowController@show');
Route::get('/product/{product}/get', 'Product\Show\NewProductShowController@productAjax');
Route::get('/product/{product}/get_choice', 'Product\Show\NewProductShowController@choiceAjax');
Route::get('/product/{product}/votes', 'Product\Vote\VoteController@show');
//UPDATE LATER IF NEEDED
//Route::get('/{product}/views', 'Product\Show\NewProductShowController@viewCount');
Route::put('/product/{product}/views', 'Product\Show\NewProductShowController@logView');
Route::get('/product/{product}/comments', 'Product\Comment\NewProductCommentController@index');

Route::get('/product/used/{product}', 'Product\Show\UsedProductShowController@show');
Route::get('/product/used/{product}/comments', 'Product\Comment\UsedProductCommentController@index');

Route::get('/category/main', 'Category\CategoryController@main')->name('categoryMain');
Route::get('/category/{category}', 'Category\CategoryController@category');

Route::get('/follow/{shop}', 'Shop\FollowController@show');

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

  Route::get('/secret/admin/database', 'Admin\AdminController@databasePage')->name('databaseAdmin');
  Route::get('/secret/admin/database/query', 'Admin\AdminController@query')->name('databaseQuery');
  Route::put('/secret/admin/database/query', 'Admin\AdminController@insert')->name('databaseInsert');

  Route::get('/secret/admin/campaign', 'Admin\Campaign\CampaignController@index')->name('campaignAdmin');
  Route::post('/secret/admin/campaign/add', 'Admin\Campaign\CampaignController@post')->name('campaignAdd');
  Route::delete('/secret/admin/campaign/delete', 'Admin\Campaign\CampaignController@delete')->name('campaignDelete');
});

/*
|--------------------------------------------------------------------------
| Utillity Api
|--------------------------------------------------------------------------
*/
Route::get('/api/getter/shop/{id}', 'Api\Getter@getShop');
Route::get('/api/getter/shop_account/{id}', 'Api\Getter@getBankAccount');
Route::get('/api/getter/my_products', 'Api\Getter@getMyProduct');
Route::get('/api/getter/shipping_info/{id}', 'Api\Getter@getShipping');

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

  Route::get('/collection/{collection}/edit/get_myproducts', 'Collection\CollectionEditController@getMyProduct');

  Route::post('/collection/{collection}/upload/{id}', 'Collection\CollectionEditController@uploadPhoto');
  Route::delete('/collection/image/{id}', 'Collection\CollectionEditController@deletePhoto');
  Route::get('/collection/image/{id}', 'Collection\CollectionEditController@photo');
  Route::delete('/collection/{collectionId}/delete/{productId}', 'Collection\CollectionEditController@deleteProduct');

  // Add to collection from product page api
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
  Route::put('/cart/mycart/clear', 'CartController@clear');
});


/*
|--------------------------------------------------------------------------
| Order via Email auth middleware not applied
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

Route::get('/error/order_deleted', 'Order\EmailController@deletedView')->name('orderDeleted');
/*
|--------------------------------------------------------------------------
| Order via Site with auth middleware
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth']], function () {
  Route::get('/order/selling/get', 'Order\OrderController@getSellingInbox');
  Route::get('/order/buying/get', 'Order\OrderController@getBuyingInbox');

  Route::get('/order/selling/history', 'Order\OrderController@sellingHistoryPage');
  Route::get('/order/buying/history', 'Order\OrderController@buyingHistoryPage');
  Route::get('/order/selling/history/get', 'Order\OrderController@getSellingHistory');
  Route::get('/order/buying/history/get', 'Order\OrderController@getBuyingHistory');

  Route::post('/order/sending', 'Order\OrderController@store');
  Route::get('/order/selling', 'Order\OrderController@sellingPage')->name('sellingOrder');
  Route::get('/order/buying', 'Order\OrderController@buyingPage')->name('buyingOrder');
  Route::get('/order/{order}', 'Order\OrderController@orderView')->name('orderView');
  Route::put('/order/{order}/transaction', 'Order\OrderController@transactionConfirm')->name('confirmPayment');
  Route::put('/order/{order}/confirm_shipping', 'Order\OrderController@confirmShipping');
  Route::put('/order/{order}/deny', 'Order\OrderController@deny');
  Route::post('/order/{order}/reviews', 'Order\OrderController@leaveReview');
});


Route::group(['middleware' => ['auth']], function () {

  Route::get('/mycollection', 'Collection\CollectionController@index')->name('myCollection');
  Route::get('/following', 'User\FollowingController@index')->name('following');
  Route::delete('/unfollow', 'User\FollowingController@unfollow')->name('unfollow');
  /*
  |--------------------------------------------------------------------------
  | Notification Routes
  |--------------------------------------------------------------------------
  */
  Route::get('/notification', 'Notification\NotificationController@index');
  Route::get('/notification/get', 'Notification\NotificationController@get');
  Route::put('/notification/read', 'Notification\NotificationController@markAsRead');
  Route::put('/notification/read_all', 'Notification\NotificationController@markAllAsRead');
  Route::delete('/notification/delete', 'Notification\NotificationController@clearAll');


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
  Route::post('/product/{product}/comments', 'Product\Comment\NewProductCommentController@create');
  Route::delete('/product/{product}/comments/{comment}', 'Product\Comment\NewProductCommentController@delete');
  //Votes
  Route::post('/product/{product}/votes', 'Product\Vote\VoteController@create');
  Route::delete('/product/{product}/votes', 'Product\Vote\VoteController@delete');
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
  Route::get('/myproduct/new', 'Product\User\MyProductController@myproductPage');
  Route::get('/myproduct/used', 'Product\User\MyProductController@myUsedProductPage');
  //Stock
  Route::get('/myproduct/stock', 'Product\Stock\StockController@index');
  Route::put('/myproduct/stock/set_amount/{product}', 'Product\Stock\StockController@update');
  //Shipping edit for all products
  Route::get('/myproduct/shipping', 'Shop\Settings\ShippingController@index');
  Route::put('/myproduct/shipping/update', 'Shop\Settings\ShippingController@update');

  Route::post('/product/used/{product}/comments', 'Product\Comment\UsedProductCommentController@create');
  Route::delete('/product/used/{product}/comments/{comment}', 'Product\Comment\UsedProductCommentController@delete');

  Route::post('/follow/{shop}', 'Shop\FollowController@create');
  Route::delete('/follow/{shop}', 'Shop\FollowController@delete');

}); //End auth middleware

/*
|--------------------------------------------------------------------------
| Shop Edit Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth']], function () {
  Route::get('/settings/profile', 'Shop\Settings\ShopEditController@index');
  Route::get('/settings/get_user', 'Shop\Settings\ShopEditController@getUserInfomation');
  Route::put('/settings/public_info', 'Shop\Settings\ShopEditController@updatePublicInfo');
  Route::put('/settings/personal_info', 'Shop\Settings\ShopEditController@updatePrivateInfo');
  Route::put('/settings/cover', 'Shop\Settings\ShopEditController@updateCover');
  Route::put('/settings/thumbnail', 'Shop\Settings\ShopEditController@updateThumbnail');

  Route::get('/settings/notification', 'Shop\Settings\ShopEditController@index');
  Route::get('/settings/notification/get', 'Notification\Settings\NotificationSettingsController@get');
  Route::put('/settings/notification/update', 'Notification\Settings\NotificationSettingsController@update');

  Route::get('/manage', 'Shop\Settings\ShopEditController@managePage');

  Route::get('/manage/contact', 'Shop\Settings\ShopEditController@managePage');
  Route::get('/manage/account', 'Shop\Settings\ShopEditController@managePage');
  Route::get('/manage/showcase', 'Shop\Settings\ShopEditController@managePage');

  Route::get('/manage/contact/get', 'Shop\Settings\ContactController@get');
  Route::post('/manage/contact/create', 'Shop\Settings\ContactController@create');
  Route::put('/manage/contact/{contact}', 'Shop\Settings\ContactController@update');
  Route::delete('/manage/contact/{contact}/delete', 'Shop\Settings\ContactController@delete');
  Route::put('/manage/contact/{contact}/show', 'Shop\Settings\ContactController@toggleShow');

  Route::get('/manage/account/get', 'Shop\Settings\AccountController@get');
  Route::post('/manage/account', 'Shop\Settings\AccountController@create');
  Route::delete('/manage/account/{account}/delete', 'Shop\Settings\AccountController@delete');
  /*
  |--------------------------------------------------------------------------
  | Showcases Routes
  |--------------------------------------------------------------------------
  */
  Route::get('/manage/showcase/get', 'Showcase\ShowcaseController@get');
  Route::post('/manage/showcase/create', 'Showcase\ShowcaseController@create');
  Route::put('/manage/showcase/order/update', 'Showcase\ShowcaseController@updateOrder');
  Route::delete('/manage/showcase/{showcase}/delete', 'Showcase\ShowcaseController@remove');
  Route::put('/manage/showcase/{showcase}/toggle_show', 'Showcase\ShowcaseController@showOption');
  //Showcase Edit
  Route::get('/manage/showcase/{showcase}/edit', 'Showcase\ShowcaseEditController@index');
  Route::get('/manage/showcase/{showcase}/get_product', 'Showcase\ShowcaseEditController@getProduct');
  Route::post('/manage/showcase/{showcase}/add_product/{id}', 'Showcase\ShowcaseEditController@storeProduct');
  Route::put('/manage/showcase/{showcase}/update', 'Showcase\ShowcaseEditController@update');

  Route::get('/promotions', 'Management\PromotionController@index')->name('promotionEdit');
  Route::get('/promotions/code', 'Management\PromotionController@codePage')->name('promotionCode');
  Route::get('/promotions/code_get', 'Management\PromotionController@getCodes');
  Route::post('/promotions/code', 'Management\PromotionController@createCode');
  Route::delete('/promotions/code/{discount}', 'Management\PromotionController@removeCode');
  Route::post('/promotions/code/validate', 'Management\PromotionController@validateCode');

  Route::get('/promotions/discount', 'Management\PromotionController@discountPage')->name('promotionDiscount');
  Route::get('/promotions/discount/product', 'Management\PromotionController@getProduct');
  Route::put('/promotions/discount/{product}/add', 'Management\PromotionController@applyDiscount');
  Route::put('/promotions/discount/{product}/delete', 'Management\PromotionController@removeDiscount');

  Route::get('/promotions/campaign', 'Management\PromotionController@campaignPage')->name('promotionCampaign');
  Route::get('/promotions/campaign/get_product', 'Management\PromotionController@getCampaignProduct');
  Route::post('/promotions/campaign/add/{product}', 'Management\PromotionController@addToCampaign');
  Route::delete('/promotions/campaign/remove/{product}', 'Management\PromotionController@removeFromCampaign');

});
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
  //Route::delete('/{shop}/reviews/delete/{feedback}', 'ReviewController@delete');

});
