<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendContactEmail;


class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $name;
    public $email;
    public $comment;
    public $cv;
    
    public function __construct($name, $email, $comment, $cv = null)
    {
        $this->name = $name; 
        $this->email = $email; 
        $this->comment = $comment; 
        $this->cv = $cv; 
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Mail::to(env('MAIL_SEND_TO'))
            ->send(new SendContactEmail($this->name, $this->email, $this->comment, $this->cv));
    }
}
