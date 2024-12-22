<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FirebaseNotifications;

class FirebaseNotification extends Notification
{
    protected $messaging;
    
    // If you intend to use $userRepository later, you can define it as a constructor parameter
    // protected $userRepository;
    
    public function __construct()
    {
        $firebase = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')));

        $this->messaging = $firebase->createMessaging();
    }

    public function sendNotification($deviceToken, $title, $body, array $data = [])
    {
        // Corrected Firebase Notification instantiation
        $notification = FirebaseNotifications::create($title, $body);

        // Prepare the CloudMessage with the target device token
        $message = CloudMessage::withTarget('token', $deviceToken)
            ->withNotification($notification)
            ->withData($data);

        // Send the notification
        return $this->messaging->send($message);
    }
}