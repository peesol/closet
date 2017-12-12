<?php

namespace Closet\Policies;

use Closet\Models\User;
use Closet\Models\Collection;
use Closet\Models\Shop;
use Closet\Models\CollectionImage;
use Illuminate\Auth\Access\HandlesAuthorization;

class CollectionPolicy
{
    use HandlesAuthorization;

        public function store(User $user, Shop $shop)
        {
            return $user->id === $shop->user_id;
        }

        public function edit(User $user, Collection $collection)
        {
            return $user->id === $collection->shop->user_id;
        }

        public function update(User $user, Collection $collection)
        {
            return $user->id === $collection->shop->user_id;
        }

        public function delete(User $user, Collection $collection)
        {
            return $user->id === $collection->shop->user_id;
        }
}
