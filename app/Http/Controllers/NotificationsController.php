<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;
use Pusher\PusherException;

/**
 *
 */
class NotificationsController extends Controller
{
    /**
     * @param Request $request
     * @return string
     * @throws PusherException
     */
    public function broadcastAuth(Request $request): string
    {
        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'));
        return $pusher->socket_auth($request->channel_name, $request->socket_id);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function allReadNotifications(Request $request): JsonResponse
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteNotification(Request $request): JsonResponse
    {
        try {
            $notification_id = $request->input('id');
            $notification = Auth::user()->notifications->find($notification_id);
            if ($notification) {
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
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error',
                'payload' => $e
            ]);
        }

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function setReadNotification(Request $request): JsonResponse
    {
        $notification_id = $request->input('id');
        $notification = Auth::user()->notifications->find($notification_id);
        if ($notification) {
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

    /**
     * @return JsonResponse
     */
    public function getNotifications(): JsonResponse
    {
        $notifications = Auth::user()->notifications;
//        $number = 0;
        foreach ($notifications as $not) {
            $data = $not['data'];
            $not->author = User::find($data['author']['id']);
//            if($not->read_at === null){
//                $number++;
//            }
        }
        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $notifications
        ]);
    }
}
