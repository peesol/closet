<?php

namespace Closet\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $locale;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $locale)
    {
        $this->user = $user;
        $this->locale = $locale;
        $this->subject = __('message.email_verification_subject');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        app()->setLocale($this->locale);
        return $this->markdown('email.markdown.verifyemail')->with([
        'email_token' => $this->user->email_token,
        'name' => $this->user->name,
        ]);
    }
}
