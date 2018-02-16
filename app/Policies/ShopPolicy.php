<?php

namespace Closet\Policies;

use Closet\Models\User;
use Closet\Models\Shop;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShopPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
     public function edit(User $user, Shop $shop)
     {
       //only user_id=shopuser_id can access
         return $user->id === $shop->user_id;
     }

    public function update(User $user, Shop $shop)
    {
      //only user_id=shopuser_id can update
        return $user->id === $shop->user_id;
    }
    
    public function delete(User $user, Shop $shop)
    {
      //only user_id=shopuser_id can update
        return $user->id === $shop->user_id;
    }
}
