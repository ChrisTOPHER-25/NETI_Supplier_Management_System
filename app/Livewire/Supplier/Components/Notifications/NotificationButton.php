<?php

namespace App\Livewire\Supplier\Components\Notifications;

use App\Models\NotificationRecipient;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationButton extends Component
{

    public $unreadNotifCount = 0;

    public function render()
    {
        return view('livewire.supplier.components.notifications.notification-button');
    }

    public function RefreshCounter() {
        $this->unreadNotifCount = 
        NotificationRecipient::where('user_id', Auth::user()->id)->where('status', 'unread')->count();
    }
}
