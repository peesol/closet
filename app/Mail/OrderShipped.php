<?php

namespace Closet\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $locale;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $locale)
    {
      $this->order = $order;
      $this->locale = $locale;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      app()->setLocale($this->locale);
      return $this->markdown('email.order.shipped')->subject(__('message.shipped_subject', ['name' => $this->order->reciever]).' ['. $this->order->updated_at->format('d-m-Y') .']');
    }
}
