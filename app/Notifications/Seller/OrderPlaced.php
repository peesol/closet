<?php

namespace Closet\Notifications\Seller;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;

class OrderPlaced extends Notification implements ShouldQueue
{
    use Queueable;

    public $message;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
        $this->queue = 'notify';
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
          'type' => 'order_placed',
          'body' => $this->message
        ];
    }

    public function toBroadcast($notifiable)
    {
      return (new BroadcastMessage([
        'translate' => 'order_placed',
        'body' => $this->message
      ]))->onQueue('notify');
    }
}
