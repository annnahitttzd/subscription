<?php

namespace App\Mail;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $post;
    public function __construct(Post $post)
    {
        $this->post= $post;
    }
    public function build()
    {
        return $this->view('email', ['post' => $this->post])
            ->subject('New Post');
    }

}
