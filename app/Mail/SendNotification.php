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
        public $websiteName;
        public function __construct(Post $post, $websiteName)
        {
            $this->post= $post;
            $this->websiteName = $websiteName;

        }
        public function build()
        {
            return $this->view('email', [
                'post' => $this->post,
                'websiteName'=>$this->websiteName
            ])
                ->subject('New Post');
        }

    }
