<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Subscriptions;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class SubscribeController extends Controller
{

    public function subscribe(Request $request, $topic)
    {
        $request->validate(
            [
                'url' => 'required'
            ]
        );
        
        $sub = new Subscriptions();

        $sub->topic = $topic;
        $sub->url = $request->url;

        $sub->save();

        $response = ['url'=>$sub->url,'topic'=>$sub->topic];

        return $response;
    }

    public function publish(Request $request,$topic)
    {
        $subscribers = Subscriptions::where('topic',$topic)->get(['url','topic']);

        if ($subscribers->isNotEmpty()) {
            foreach ($subscribers as $key => $value) {
                $sub_payload = [
                    'topic'=>$value->topic,
                    'data'=>$request->all()
                ];

                $response = Http::post($value->url,$sub_payload);
                Log::error("Subscriber has been notified", ["error" => $response]);
            }
            return response()->json(['msg'=>'Publishing successful.'], 200);
        }else {            
            return response()->json(['msg'=>'Topic not found'], 404);
        }
        
    }

}
