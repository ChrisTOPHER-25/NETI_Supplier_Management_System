<?php

namespace App\Livewire\Supplier\Components\Notifications;

use App\Models\Notification;
use App\Models\NotificationMessage;
use App\Models\NotificationRecipient;
use App\Models\NotificationTitle;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationMessages extends Component
{
    // Title, Status, Message, Time, Date, Owner
    public $notifications = [];

    public function render()
    {
        return view('livewire.supplier.components.notifications.notification-messages');
    }

    public function RefreshNotifications()
    {
        try {
            $this->reset('notifications');
            foreach (NotificationRecipient::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get() as $notifRecipient) {
                $notification = Notification::findOrFail($notifRecipient->notification_id);
                array_push($this->notifications, [
                    'title' => NotificationTitle::findOrFail($notification->notif_title_id)->title,
                    'status' => $notifRecipient->status,
                    'message' => NotificationMessage::findOrFail($notification->notif_message_id)->message,
                    'time' => date_format($notification->created_at, 'h:i:s'),
                    'date' => date_format($notification->created_at, 'm/d/Y'),
                    'owner' => $notification->user_id
                ]);
            }
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    public function ReadAllMessages() {
        foreach (NotificationRecipient::where('user_id', Auth::user()->id)->get() as $notifRecipient) {
            $notifRecipient->status = 'read';
            $notifRecipient->save();
        }
    }
}
