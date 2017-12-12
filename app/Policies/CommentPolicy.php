<?php

namespace Closet\Policies;

use Closet\Models\User;
use Closet\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id;
    }
}
