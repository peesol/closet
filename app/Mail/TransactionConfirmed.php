<?php

namespace Closet\Mail;

use App;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransactionConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $data;
    public $locale;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $data, $locale)
    {
      App::setLocale($locale);
      $this->order = $order;
      $this->data = $data;
      $this->locale = $locale;
      $this->subject = __('message.transaction_subject').' '.$this->order->sender.' ['. $this->order->updated_at->format('d-m-Y') .']';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->view('email.order.transaction');
    }
}
