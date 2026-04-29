<div>
    <div class="ps-0">
        @if (empty($msgData) == false)
        <small class="d-flex align-items-center gap-1">
            <span class="fw-normal">{{date('h:i:s')}}&nbsp;&nbsp;</span>
            <span class="badge rounded-pill bg-{{$msgData['color']}} p-2 pt-1 pb-1">
                @if ($msgData['color'] == 'success')
                Success
                @elseif ($msgData['color'] == 'danger')
                Failed
                @elseif ($msgData['color'] == 'warning')
                <span class="text-black">Warning</span>
                @endif
            </span>&nbsp;
            <span class="fw-normal">{{$msgData['message']}}</span>
        </small>
        @endif
    </div>
</div>