<div wire:poll='RefreshNotifications'>
    {{-- Read All Button --}}
    <div class="row mb-2 justify-content-end">
        <div class="col-auto">
            <form wire:submit='ReadAllMessages'>
                <button class="btn btn-sm text-white fw-bold" style="background: #3e5877;">Read All</button>
            </form>
        </div>
    </div>
    {{-- Notification Messages --}}
    <div class="table-responsive">
        <table class="table table-borderless">
            <tbody>
                @inject('User', App\Models\User::class)
                @foreach ($notifications as $notification)
                <tr>
                    <td>
                        <div
                            class="col border border-secondary-subtle rounded-4 p-2 ps-3 pe-3 d-flex flex-column bg-white">
                            {{-- Notif Title --}}
                            <span class="link-primary d-flex justify-content-between align-items-center">
                                {{ $notification['title'] }}
                                {{-- Unread Dot --}}
                                @if ($notification['status'] == 'unread')
                                <span style="color: rgb(226, 93, 93);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor"
                                        class="bi bi-circle-fill" viewBox="0 0 16 16">
                                        <circle cx="8" cy="8" r="8" />
                                    </svg>
                                </span>
                                @endif
                            </span>
                            <hr class="mt-2 mb-2">
                            <a class="d-flex flex-column gap-4 text-decoration-none link-secondary"
                                style="cursor:pointer">
                                {{-- Notif Message --}}
                                <small>
                                    @if ($notification['owner'] == Auth::user()->id)
                                    <span>You</span>
                                    @else
                                    <span>{{ $User::findOrFail($notification['owner'])->name }}</span>
                                    @endif
                                    {{ $notification['message'] }}
                                </small>
                                {{-- Notif Time & Date --}}
                                <small class="link-secondary d-flex justify-content-between">
                                    <span>{{ $notification['time'] }}</span>
                                    <span>{{ $notification['date'] }}</span>
                                </small>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>