<?php

namespace App\Services;

use App\Models\User\UserProfileModel;
use Exception;
use Firebase\JWT\JWT;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FCMService
{
    protected $guzzle;

    public function __construct()
    {
        $this->guzzle = new GuzzleClient([
            'verify' => Storage::path('cacert.pem'),
        ]);
    }

    public function sendNotification(int $userId, string $title, string $body): array
    {
        try {
            $user = UserProfileModel::findOrFail($userId);
            $fcmToken = $user->fcm_token;

            if (!$fcmToken) {
                throw new Exception('User does not have a device token', 400);
            }

            if (!preg_match('/^[a-zA-Z0-9\-_:]+$/', $fcmToken)) {
                throw new Exception('Invalid device token format', 400);
            }

            // Get access token
            $accessToken = $this->getAccessToken();

            // Prepare notification payload
            $projectId = config('services.fcm.project_id');
            $data = [
                'message' => [
                    'token' => $fcmToken,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                ],
            ];
            $payload = json_encode($data);

            $headers = [
                "Authorization: Bearer $accessToken",
                'Content-Type: application/json',
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_CAINFO, Storage::path('cacert.pem'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

            $response = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);

            if ($err) {
                throw new Exception('cURL Error: ' . $err, 500);
            }

            return [
                'success' => true,
                'message' => 'Notification has been sent',
                'response' => json_decode($response, true),
            ];
        } catch (Exception $e) {
            Log::error('FCM Notification Error: ' . $e->getMessage(), ['user_id' => $userId]);
            throw $e;
        }
    }

    protected function getAccessToken(): string
    {
        $credentialsPath = Storage::path('firebase/firebase_credentials.json');
        $serviceAccount = json_decode(file_get_contents($credentialsPath), true);

        if (!isset($serviceAccount['private_key'], $serviceAccount['client_email'])) {
            throw new Exception('Invalid Firebase service account JSON', 500);
        }

        $now = time();
        $jwtPayload = [
            'iss' => $serviceAccount['client_email'],
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => $now + 3600,
            'iat' => $now,
        ];

        $jwt = JWT::encode($jwtPayload, $serviceAccount['private_key'], 'RS256');

        $response = $this->guzzle->post('https://oauth2.googleapis.com/token', [
            'form_params' => [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt,
            ],
        ]);

        $tokenData = json_decode($response->getBody(), true);
        return $tokenData['access_token'];
    }
}
