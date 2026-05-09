<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(10);
        return view('notifications.index', compact('notifications'));
    }

    public function apiIndex(Request $request)
    {
        $notifications = $request->user()->notifications()->limit(10)->get()->map(fn($n) => [
            'id'         => $n->id,
            'data'       => $n->data,
            'read_at'    => $n->read_at,
            'created_at' => $n->created_at->diffForHumans(),
        ]);

        return response()->json([
            'notifications' => $notifications,
            'unread'        => $request->user()->unreadNotifications()->count(),
        ]);
    }

    public function visit(string $id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        $url = $notification->data['url'] ?? route('home');
        return redirect($url);
    }

    public function readAll()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    }

    public function read(string $id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return response()->json(['ok' => true]);
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'endpoint'   => 'required|string',
            'public_key' => 'required|string',
            'auth_token' => 'required|string',
        ]);

        auth()->user()->updatePushSubscription(
            $request->endpoint,
            $request->public_key,
            $request->auth_token,
            $request->content_encoding ?? 'aesgcm'
        );

        return response()->json(['ok' => true]);
    }
}
