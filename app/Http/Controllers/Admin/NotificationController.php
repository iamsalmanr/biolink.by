<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = Notification::orderbyDesc('id')->get();
        $totalUnread = Notification::where('status', 0)->get()->count();

        return view('admin.notifications.index', compact('notifications', 'totalUnread'));
    }


    /**
     * Redirect to the notification link
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function view($id)
    {
        $notification = Notification::where('id', $id)->firstOrFail();
        $updateStatus = $notification->update(['status' => 1]);
        if ($updateStatus) {
            return redirect($notification->link);
        }
    }

    /**
     * Mark all notifications as read
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsRead()
    {
        Notification::where('status', 0)->update(['status' => 1]);
        quick_alert_success(___('All notifications marked as read'));
        return back();
    }

    /**
     * Delete all read notifications
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAllRead()
    {
        Notification::where('status', 1)->delete();
        quick_alert_success(___('Deleted Successfully'));
        return back();
    }
}
