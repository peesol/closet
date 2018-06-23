<?php

namespace Closet\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderCancle extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $locale;
    public $contact;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $locale, $contact)
    {
      $this->order = $order;
      $this->locale = $locale;
      $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      app()->setLocale($this->locale);
      return $this->markdown('email.order.cancled')->subject(__('message.cancled_subject'). ' ['. $this->order->deleted_at->format('d-m-Y') .']');
    }
}
