<?php

namespace Closet\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderingSeller extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $locale;
    public $sender;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $locale, $sender)
    {
        $this->order = $order;
        $this->locale = $locale;
        $this->sender = $sender;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        app()->setLocale($this->locale);
        return $this->markdown('email.order.ordering_seller')->subject(__('message.ordering_subject').' '.$this->order->sender.' ['. $this->order->created_at->format('d-m-Y') .']');
    }
}
