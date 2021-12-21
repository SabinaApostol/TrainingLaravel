<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $products;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($products, $order)
    {
        $this->products = $products;
        $this->order = $order;
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
