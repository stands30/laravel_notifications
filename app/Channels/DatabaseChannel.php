<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Channels\DatabaseChannel as IlluminateDatabaseChannel;

class DatabaseChannel extends IlluminateDatabaseChannel
{
    /**
    * Send the given notification.
    *
    * @param mixed $notifiable
    * @param \Illuminate\Notifications\Notification $notification
    * @return \Illuminate\Database\Eloquent\Model
    */
    public function send($notifiable, Notification $notification)
    {
        \Log::info("notifiable ".json_encode( $notifiable ).' || '. json_encode( $notification ));
        return $notifiable->routeNotificationFor('database')->create([
            'id'      => $notification->id,
            'type'    => get_class($notification),
            'notification_type'=> $notification->notification_type ?? null,
            'data'    => $notification->notification_message,
            'read_at' => null,
        ]);
    }
}
