<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Jobs\SendPushNotificationJob;

class BroadcastController extends Controller
{
    public function index() {
        return view('admin.broadcast.index');
    }

    public function broadcastMessage(Request $request) {
        try {
            addNotification(0, 0, $request->title, $request->description, 'new_broadcast');
            dispatch(new SendPushNotificationJob($request->title, $request->description, 'broadcast'))->delay(now()->addSeconds(2));
            return redirect()->back()->with('success_msg',"Message successfully broadcast");

        } catch(\Throwable $e) {
            return redirect()->back()->with('error_msg', $e->getMessage());
        }
    }
}
