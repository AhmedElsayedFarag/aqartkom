<?php

namespace App\Helpers;

use App\DataTransferObjects\FCMDTO;
use App\Jobs\AddNotificationsToUsersJob;
use Google\Client as GClient;
use Google\Service\FirebaseCloudMessaging;
use Google_Exception;
use Illuminate\Support\Facades\Http;

define("BASE_URL", "https://fcm.googleapis.com/v1/projects/" . config('fcm.fcm_project_name') . "/messages:send");

class FCMHelper
{
    public static function configureClient()
    {
        $path = base_path() . '/' . \config('fcm.fcm_json');
        $client = new GClient();
        try {
            $client->setAuthConfig($path);
            $client->addScope(FirebaseCloudMessaging::CLOUD_PLATFORM);

            $accessToken = static::generateToken($client);

            $client->setAccessToken($accessToken);

            $oauthToken = $accessToken["access_token"];

            return $oauthToken;
        } catch (Google_Exception $e) {
            return $e;
        }
    }

    private static function generateToken($client)
    {
        $client->fetchAccessTokenWithAssertion();
        $accessToken = $client->getAccessToken();

        return $accessToken;
    }
    /**
     * Undocumented function
     *
     * @param string $userToken
     * @param array $bookingDetails =['id'=>'','date' => '','vendor' => '']
     * @return void
     */
    public static function sendMessage(FCMDTO $dto)
    {

        $oauthToken = static::configureClient();

        return Http::acceptJson()->withHeaders([
            'Authorization' => 'Bearer ' . $oauthToken
        ])->post(\BASE_URL, [
            "message" => [
                'token' => $dto->getToken(),
                "notification" => $dto->getNotification(),
                "data" => $dto->getData(),
            ],
        ])->json();
    }
    public static function sendTopic(FCMDTO $dto, string $userType)
    {
        $oauthToken = static::configureClient();
        AddNotificationsToUsersJob::dispatch(new \Modules\Notification\DataTransferObjects\NotificationDto(
            $dto->getNotification()['title'],
            $dto->getNotification()['body'],
            'Modules\Notification\Notifications\SendTopicNotification',
        ), $userType)->onQueue('notifications');
        return Http::acceptJson()->withHeaders([
            'Authorization' => 'Bearer ' . $oauthToken
        ])->post(BASE_URL, [
            "message" => [
                'topic'         => $dto->getTopic(),
                "notification"  => $dto->getNotification(),
                "data"          => $dto->getData(),
            ],
        ])->json();
    }
}