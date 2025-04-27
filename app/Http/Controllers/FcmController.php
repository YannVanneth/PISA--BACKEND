<?php

namespace App\Http\Controllers;

use App\Services\FCMService;
class FcmController extends Controller
{
    public function updateDeviceToken(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'fcm_token' => 'required|string',
        ]);

        $request->user()->update(['fcm_token' => $request->fcm_token]);

        return response()->json(['message' => 'Device token updated successfully']);
    }

    public function sendFcmNotification(Request $request)
    {
       try{

           $validate = $request->validate([
               'title' => 'required|string',
               'body' => 'required|string',
               'data' => 'nullable|array',
                'user_id' => 'required|integer',
           ]);

           $res =  (new FCMService())->sendNotification($request->user_id, $request->title, $request->body);

           return response()->json(['message' => 'Notification has been sent'], 200);

       } catch (\Exception $e) {
           return response()->json(['error' => 'Failed to send notification: ' . $e->getMessage()], 500);
       }
    }
}
