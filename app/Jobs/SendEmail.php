<?php

namespace App\Jobs;

use App\Mail\NewOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $products = [];
    protected $name, $email, $comments;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($products, $name, $email, $coomments)
    {
        $this->products = $products;
        $this->name = $name;
        $this->email = $email;
        $this->comments = $coomments;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new NewOrder($this->products, $this->name, $this->email, $this->comments ?? NULL);
        Mail::to(config('mail.to.addr'))->send($email);
    }
}
