<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscribeRequest;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function subscribeToWebsite(SubscribeRequest $request)
    {
        $existingSubscriber = Subscriber::where('user_id', $request->user_id)
            ->where('website_id', $request->website_id)
            ->first();
        if ($existingSubscriber){
            return response()->json(['error'=>'user is already subscribed'], 422);
        }
        $subscriber = Subscriber::create([
            'user_id' => $request->user_id,
            'website_id' => $request->website_id,
        ]);

        return response()->json(['message' => 'Subscription created successfully', 'data' => $subscriber], 201);
    }

}
