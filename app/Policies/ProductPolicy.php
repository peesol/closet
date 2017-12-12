<?php

namespace Closet\Policies;

use Closet\Models\{User, Shop, Product};
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function store(User $user, Product $product)
        {
            return $user->id === $product->shop->user_id;
        }
    public function create(User $user)
        {
            return $user->canSell() && $user->id === $user->shop->id;
        }

    public function edit(User $user, Product $product)
        {

            return $user->id === $product->shop->user_id;
        }

    public function update(User $user, Product $product)
        {

            return $user->id === $product->shop->user_id;
        }

    public function delete(User $user, Product $product)
        {
            return $user->id === $product->shop->user_id;
        }

}
