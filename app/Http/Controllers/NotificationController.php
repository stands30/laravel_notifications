<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\UserNotification;
use Notification;

class NotificationController extends Controller
{
    public static function index(Request $request)
    {
        $userList = User::get();
        $notifications = auth()->user()->unreadNotifications->where('expiration_date','<', now());
        return view('notifications.create_notification', compact('userList','notifications'));
    }


    public static function store(Request $request)
    {
         $request->validate([
            'type' => 'required',
            'data' => 'required',
            'expiration_date' => 'required',
            'destination' => 'required',
        ]);

        // if ($validator->fails()) {
        //     return back()->withErrors( $validator )->withInput($request->input());
        // }
        $postData = $request->post();
        if( $postData['destination'] == 'all'){
            $users = User::get();
        }else{
            $users = User::find($postData['destination']);
        }
        Notification::send($users, new UserNotification($postData));

        return redirect()->route('users.index')
                        ->with('success','User created successfully.');

    }
}
