<?php

namespace App\Http\Controllers;

use App\Console\Commands\SendPostEmails;
use App\Http\Requests\PostRequest;
use App\Jobs\MailSending;
use App\Models\Email;
use App\Models\Post;
use App\Models\Subscriber;
use App\Models\Website;
use Illuminate\Http\Request;

        class PostController extends Controller
        {
            public function addPost(PostRequest $request)
            {
                $existingWebsite = Website::find($request->website_id);
                if (!$existingWebsite){
                    return response()->json(['message'=>"website doesn't exist"], 404);
                }
                $post = Post::create([
                    'website_id' => $request->website_id,
                    'title' =>$request->title,
                    'description' =>$request->description,
                ]);
//                $subscribers = Subscriber::where('website_id', $post->website_id)->get();
//
//                foreach ($subscribers as $subscriber){
//                    Email::create([
//                        'subscriber_id'=> $subscriber->id,
//                        'post_id'=> $post->id,
//                    ]);
//                    MailSending::dispatch($subscriber, $post, $existingWebsite)->onQueue('emails');
//                }
                return response()->json(['message' => 'Subscription created successfully', 'data' => $post], 201);
            }
        public function getWebsitePosts(Request $request)
        {
            $websiteId = $request->input('website_id');
            $posts = Post::where('website_id', $websiteId)->paginate(1);
            if ($posts->isEmpty()){
                return response()->json(['message'=>"no posts" ], 404);
            }
            return response()->json(['data' => $posts], 200);
        }
    }
