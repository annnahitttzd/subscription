<?php

namespace App\Jobs;

use App\Mail\SendNotification;
use App\Models\Email;
use App\Models\Post;
use App\Models\Subscriber;
use App\Models\User;
use App\Models\Website;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

        class   MailSending implements ShouldQueue
        {
            use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
            public $emailRecord;
            public $subscriber;
            public $post;
            public $websiteName;

            public function __construct(Email $emailRecord, Subscriber $subscriber, Post $post, Website $websiteName)
            {
                $this->emailRecord = $emailRecord;
                $this->subscriber = $subscriber;
                $this->post = $post;
                $this->websiteName = $websiteName;
            }

            public function handle(): void
            {
                $this->onQueue('emails');
                    Mail::to($this->subscriber->user->email)->send(new SendNotification($this->post, $this->websiteName->name));

            }
        }
