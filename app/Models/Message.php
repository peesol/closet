<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['sender_id', 'reciever_id', 'sender', 'reciever', 'type', 'title', 'body', 'read', 'confirmed', 'trans', 'total'];

    public function User()
    {
      return $this->belongsTo(User::class);
    }
}
