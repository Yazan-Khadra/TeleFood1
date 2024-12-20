<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

 class FcmController extends Controller
{
    public $messaging;

    public $userRepository;

    public function __construct()
    {
        $firebase = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')));

        $this->messaging = $firebase->createMessaging();
    }

    public function sendNotification($deviceToken, $title, $body, array $data = [])
    {
        $notification = Notification::create($title, $body);

        $message = CloudMessage::withTarget('token', $deviceToken)
            ->withNotification($notification)
            ->withData($data);

        return $this->messaging->send($message);
    }
    public function notifyUsers(Product $product)
    {
        $resturant = $product->Store;
        $title = 'New Product Added';
        $body = 'User '.$resturant->name.' '.' has added a new product'.$product->name;

        $users = $this->userRepository->getAllUsersHasFcmToken();

        foreach ($users as $user) {
            $this->sendNotification($user->fcm_token, $title, $body, ['product_id' => $product->id]);
        }
    }
    
}
