<?php

namespace App\Console\Commands;

use App\Jobs\MailSending;
use App\Mail\SendNotification;
use App\Models\Email;
use App\Models\Post;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendPostEmails extends Command
    {
        protected $signature = 'send:emails';
        protected $description = 'Sending email when new post is added';
        public function handle()
        {
            $posts = Post::with('emails.subscriber.user')->chunk(100, function ($posts){
                foreach ($posts as $post) {
                    foreach ($post->emails as $email) {
                        if (!$email->sent_status) {
                            $subscriber = $email->subscriber;
                            MailSending::dispatch($subscriber, $post)->onQueue('emails');
                            $email->update(['sent_status' => true]);
                        }
                    }
                }

            });
        }





    }
