<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class ToastNotification extends Component
{
    public array $messages = [];

    #[On('toast')]
    public function showToast($args)
    {
        $this->messages[] = [
            'message' => $args['message'],
            'type' => $args['type'],
            'title' => ucfirst($args['type']),
            'time' => now()->format('H:i:s'),
            'icon' => $args['type'] == 'success' ? 'fi-rs-check' : 'fi-rs-cross',
        ];
    }

    public function closeToast($index)
    {
        unset($this->messages[$index]);
    }

    public function render()
    {
        return view('livewire.toast-notification');
    }
}
