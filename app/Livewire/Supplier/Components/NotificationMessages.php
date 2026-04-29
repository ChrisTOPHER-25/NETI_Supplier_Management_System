<?php

namespace App\Livewire\Supplier\Components;

use App\Models\Notification;
use App\Models\NotificationRecipient;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationMessages extends Component
{
    public $notifications = [];
    
    public function render()
    {
        return view('livewire.supplier.components.notification-messages');
    }

    public function mount() {
        $this->reset('notifications');
        $myNotifications = NotificationRecipient::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        foreach ($myNotifications as $myNotif) {
            array_push($this->notifications, Notification::findOrFail($myNotif->notification_id));
        }
    }

    public function UpdateNotifications() {
        $this->reset('notifications');
        $myNotifications = NotificationRecipient::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        foreach ($myNotifications as $myNotif) {
            array_push($this->notifications, Notification::findOrFail($myNotif->notification_id));
        }
    }

    public function UpdateNotifStatus($notifId) {
        $notification = Notification::findOrFail($notifId);
        $notificationRecipient = NotificationRecipient::where('notification_id', $notifId)->where('user_id', Auth::user()->id)->first();
        $notificationRecipient->status = 'read';
        $notificationRecipient->save();
        if (Auth::user()->user_type == 'supplier') {
            return redirect()->to(str_replace('admin', 'supplier', $notification->url));
        }
        if ($notification->url == '/admin/submitted-quotations') {
            return redirect()->to('/supplier/create-quotation');
        }
        return redirect()->to($notification->url);
    }
}
