<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\NotificationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        try{

            $notifications = NotificationModel::query()->where(
                ['user_id' => auth()->id()])->orderBy('created_at', 'desc')->get();
            return response()->json(['data' => NotificationResource::collection($notifications)], 200);

        }catch (\Exception $exception){
            return response()->json(['message' => 'Error fetching notifications', 'error' => $exception->getMessage()], 500);
        }
    }

    public function show(Request $request,$id)
    {
        // Fetch a specific notification by ID
        $notification = auth()->user()->notifications()->findOrFail($id);

        return response()->json($notification);
    }

    public function update(Request $request, $id)
    {
        // Mark a notification as read
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->update(['is_read' => true]);

        return response()->json(['message' => 'Notification marked as read']);
    }

    public function destroy(Request $request, $id)
    {
        // Delete a notification
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->delete();

        return response()->json(['message' => 'Notification deleted']);
    }
}
