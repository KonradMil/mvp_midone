<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class NotificationsController extends Controller
{
    public function broadcastAuth(Request $request)
    {
        $pusher = new Pusher(env('PUSHER_APP_KEY'),env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'));
        return $pusher->socket_auth($request->channel_name,$request->socket_id);
    }

    public function setReadNotification(Request $request)
    {
        $notification = Notification::find($request->input('id'));
        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $notification
        ]);
    }

    public function getNotifications()
    {
        $notifications = Auth::user()->notifications;
        $user = User::find(Auth::user()->id);
        foreach ($notifications as $not) {
            $data = $not['data'];
            $not->author = User::find($data['author']['id']);
        }
        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $notifications
        ]);
    }
}
