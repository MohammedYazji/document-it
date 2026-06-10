<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()
            ->notifications()
            ->latest()
            ->paginate(15);

        return view('dashboard.notifications', [
            'notifications' => $notifications,
        ]);
    }

    public function read(Request $request, string $id)
    {
        $notification = $request->user()->notifications()->findOrFail($id);

        $notification->markAsRead();

        return redirect()->back();
    }

    public function unread(Request $request, string $id)
    {
        $notification = $request->user()->notifications()->findOrFail($id);

        $notification->update(['read_at' => null]);

        return redirect()->back();
    }

    public function destroy(Request $request, string $id)
    {
        $request->user()->notifications()->where('id', $id)->delete();

        return redirect()->back();
    }
}
