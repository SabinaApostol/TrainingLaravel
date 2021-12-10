<?php

namespace App\Listeners;

use App\Events\SendEmailEvent;
use App\Mail\NewOrder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SendEmailEvent  $event
     * @return void
     */
    public function handle(SendEmailEvent $event)
    {
        Mail::to(config('mail.to.addr'))->send(new NewOrder($event->products,
            $event->name,
            $event->email,
            $event->comments ?? NULL));
    }
}
