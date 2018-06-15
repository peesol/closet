<?php

namespace Closet\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderingBuyer extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $accounts;
    public $locale;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $accounts, $locale)
    {
        $this->order = $order;
        $this->locale = $locale;
        $this->accounts = $accounts;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      app()->setLocale($this->locale);
      return $this->markdown('email.order.ordering_buyer')
      ->subject(__('message.confirmed_order_subject', ['name' => $this->order->reciever]). ' ['. $this->order->updated_at->format('d-m-Y') .']');
    }
}
