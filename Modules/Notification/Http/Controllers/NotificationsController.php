<?php

namespace Modules\Notification\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Modules\Auth\Models\User;
use Modules\Notification\Http\Resources\NotificationResource;

class NotificationsController extends Controller
{
    public function index()
    {
        $json = NotificationResource::collection(auth()->user()->notifications()->paginate());
        $this->readAll();
        return $json;
    }

    public function read(string $notification)
    {
        auth()->user()->unreadNotifications()
            ->where('id', $notification)
            ->update(['read_at' => now()]);
    }
    public function readAll()
    {
        auth()->user()->unreadNotifications()
            ->update(['read_at' => now()]);
    }
    public function destroy()
    {
        auth()->user()->notifications()->delete();
    }

    public function destroyOne($notification)
    {
        auth()->user()->notifications()->where('id', $notification)->delete();
    }
}