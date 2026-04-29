<?php

namespace App\Livewire\Supplier\Components;

use App\Models\NotificationRecipient;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationCounter extends Component
{
    public $notificationUnreadCount = 0;

    public $currentCount = 0;

    protected $listeners = [
        'UpdateNotifCounter'
    ];

    public function render()
    {
        return view('livewire.supplier.components.notification-counter');
    }

    public function mount() {
        $this->currentCount = NotificationRecipient::where('user_id', Auth::user()->id)->where('status', 'unread')->count();
        $this->notificationUnreadCount = $this->currentCount;
    }

    public function RefreshCount() {
        if (NotificationRecipient::where('user_id', Auth::user()->id)->where('status', 'unread')->count() != $this->notificationUnreadCount) {
            $this->notificationUnreadCount = NotificationRecipient::where('user_id', Auth::user()->id)->where('status', 'unread')->count();
            $this->currentCount = NotificationRecipient::where('user_id', Auth::user()->id)->where('status', 'unread')->count();
        }
    }

    // New
    public function RefreshCounter() {
        $this->notificationUnreadCount = NotificationRecipient::where('user_id', Auth::user()->id)->where('status', 'unread')->count();
    }
}
