<?php

namespace App\Livewire\Admin\Components\Notifications;

use App\Models\Notification;
use App\Models\NotificationMessage;
use App\Models\NotificationRecipient;
use App\Models\NotificationTitle;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationOffcanvas extends Component
{

    protected $listeners = [
        'CreateNotif',
    ];

    public function render()
    {
        return view('livewire.admin.components.notifications.notification-offcanvas');
    }

    public function CreateNotif($notifData) {
        try {
            $notifTitle = null;
            $notifMessage = null;
            if (NotificationTitle::where('title', $notifData['title'])->count() == 0) {
                $notifTitle = NotificationTitle::create([
                    'title' => $notifData['title'],
                ]);
            }
            if (NotificationMessage::where('message', $notifData['message'])->count() == 0) {
                $notifMessage = NotificationMessage::create([
                    'message' => $notifData['message'],
                ]);
            }
            // Create Notification
            $notification = Notification::create([
                'notif_title_id' => empty($notifTitle) ? NotificationTitle::where('title', $notifData['title'])->firstOrFail()->id : $notifTitle->id,
                'notif_message_id' => empty($notifMessage) ? NotificationMessage::where('message', $notifData['message'])->firstOrFail()->id : $notifMessage->id,
                'user_id' => Auth::user()->id,
                'url' => $notifData['url'],
            ]);
            // Recipients
            foreach ($notifData['recipients'] as $key => $value) {
                if (NotificationRecipient::where('user_id', $value)->count() > 20) {
                    // Delete first notification data from table
                    $notifToDelete = Notification::where('user_id', $value)->first();
                    if ($notifToDelete) Notification::destroy($notifToDelete->id);
                    // Delete first notification_recipient data from table
                    $notifRecToDelete = NotificationRecipient::where('user_id', $value)->first();
                    if ($notifRecToDelete) NotificationRecipient::destroy($notifRecToDelete->id);
                }
                NotificationRecipient::create([
                    'notification_id' => $notification->id,
                    'user_id' => $value,
                ]);
            }
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }
}
