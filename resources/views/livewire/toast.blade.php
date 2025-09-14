<div class="toast-container position-fixed bottom-0 end-0 p-3">
    @foreach ($messages as $message)
        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="{{ $message['icon'] }} me-2"></i>
                <strong class="me-auto">{{ $message['title'] }}</strong>
                <small>{{ $message['time'] }}</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"
                    wire:click="closeToast({{ $loop->index }})"></button>
            </div>
            <div class="toast-body">
                {{ $message['message'] }}
            </div>
        </div>
    @endforeach

</div>
