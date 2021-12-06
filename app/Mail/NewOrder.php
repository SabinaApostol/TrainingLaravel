<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $products = [];
    public $name;
    public $email;
    public $comments;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($products, $name, $email, $comments)
    {
        $this->products = $products;
        $this->name = $name;
        $this->email = $email;
        $this->comments = $comments;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.email_body');
    }
}
