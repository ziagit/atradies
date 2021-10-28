<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendJobEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $job;
    protected $user;
    public function __construct($user,$job)
    {
        $this->user = $user;
        $this->job = $job;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        $url = config('app.url')."/#/jobs/details/".$this->job->id;
        $user = $this->user;
        return $this->subject("New Job Created")
        ->view("auth.sendjob",compact('url','user'));
    }
}
