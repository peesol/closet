<?php

namespace Closet\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderDeny extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $locale;
    public $reason;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $locale, $reason)
    {
      $this->order = $order;
      $this->locale = $locale;
      $this->reason = $reason;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      app()->setLocale($this->locale);
      return $this->markdown('email.order.denied')->subject(__('message.denied_subject'). ' ['. $this->order->deleted_at->format('d-m-Y') .']');
    }
}
