<?php

namespace Closet\Mail;

use App;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderConfirmed extends Mailable
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
        App::setLocale($locale);
        $this->order = $order;
        $this->accounts = $accounts;
        $this->locale = $locale;
        $this->subject = __('message.confirmed_order_subject', ['name' => $this->order->reciever]). ' ['. $this->order->updated_at->format('d-m-Y') .']';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->view('email.order.confirmed');
    }
}
