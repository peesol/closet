<?php

namespace Closet\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'Closet\Models\Shop' => 'Closet\Policies\ShopPolicy',
        'Closet\Models\Product' => 'Closet\Policies\ProductPolicy',
        'Closet\Models\Comment' => 'Closet\Policies\CommentPolicy',
        'Closet\Models\Collection' => 'Closet\Policies\CollectionPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
