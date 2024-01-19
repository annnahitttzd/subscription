<?php

namespace App\Console\Commands;

use App\Jobs\MailSending;
use App\Mail\SendNotification;
use App\Models\Email;
use App\Models\Post;
use App\Models\Subscriber;
use App\Models\User;
use App\Models\Website;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendPostEmails extends Command
    {
        protected $signature = 'send:emails';
        protected $description = 'Sending email when new post is added';
        public function handle()
        {
            Post::query()->whereHas('website', function ($q) {
                $q->whereHas('subscribers', function ($q) {
                    $q->whereDoesntHave('emails', function ($q) {
                        $q->whereRaw('emails.post_id = posts.id');
                        $q->where('sent_status', 1);
                    });
                });
            })->chunkById(1000, function ($posts) {
                foreach ($posts as $post) {
                    $subscribers = $post->website->subscribers()->whereDoesntHave('emails', function ($q) use ($post) {
                        $q->where('post_id', $post->id);
                        $q->where('sent_status', 1);
                    })->get();
                    foreach ($subscribers as $subscriber) {
                        $emailRecord = $subscriber->emails()->where('post_id', $post->id)->first();
                        if ($emailRecord) {
                            $this->send($emailRecord, $subscriber, $post, $post->website);
                        } else {
                            $emailRecord = Email::create([
                                'subscriber_id' => $subscriber->id,
                                'post_id' => $post->id,
                                'sent_status' => 0
                            ]);
                            $this->send($emailRecord, $subscriber, $post, $post->website);

                        }
                    }
                }
            });
        }

        private function send (Email $emailRecord, Subscriber $subscriber, Post $post, Website $website)
        {
                MailSending::dispatch($emailRecord, $subscriber, $post, $website)->onQueue('emails');
                $emailRecord->update(['sent_status'=>1]);
        }

    }

//            $posts = Post::with('emails.subscriber.user')->chunk(100, function ($posts){
//                foreach ($posts as $post) {
//                    foreach ($post->emails as $email) {
//                        if (!$email->sent_status) {
//                            $subscriber = $email->subscriber;
//                            $websiteName=$post->website;
//                            MailSending::dispatch($subscriber, $post, $websiteName )->onQueue('emails');
//                            $email->update(['sent_status' => true]);
//                        }
//                    }
//                }
//
//            });
