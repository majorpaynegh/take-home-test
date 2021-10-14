<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    //

    public function subscribe(Request $request, $topic)
    {
        return $request;
        // $request->validate(
        //     [
        //         'url' => 'required'
        //     ]
        // );
    }
}
