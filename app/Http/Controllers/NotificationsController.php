<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
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

    public function allReadNotifications(Request $request)
    {
        $notifications = Auth::user()->notifications;
        foreach ($notifications as $not) {
            $data = $not['data'];
            $not->author = User::find($data['author']['id']);
        }
        $user = User::find(Auth::user()->id);
        $user->unreadNotifications->markAsRead();

        $notifications = Auth::user()->notifications;
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
    public function deleteNotification(Request $request)
    {
        try{
            $notification_id = $request->input('id');
            $notification = Auth::user()->notifications->find($notification_id);
            if($notification){
                $notification->delete();
            }
        $notifications = Auth::user()->notifications;
        foreach ($notifications as $not) {
            $data = $not['data'];
            $not->author = User::find($data['author']['id']);
        }
            return response()->json([
                'success' => true,
                'message' => 'Usunięto poprawnie.',
                'payload' => ''
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Error',
                'payload' => $e
            ]);
        }

    }
    public function setReadNotification(Request $request)
    {
        $notification_id = $request->input('id');
        $notification = Auth::user()->notifications->find($notification_id);
        if($notification){
            $notification->markAsRead();
        }
        $notifications = Auth::user()->notifications;

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

    public function getNotifications()
    {
        $notifications = Auth::user()->notification->take(5)->get();
        $number = 0;
        foreach ($notifications as $not) {
            $data = $not['data'];
            $not->author = User::find($data['author']['id']);
            if($not->read_at === null){
                $number++;
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $notifications,
        ]);
    }
}
