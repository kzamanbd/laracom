<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class Toast extends Component
{
    public array $messages = [];

    #[On('toast')]
    public function showToast($message, $type = 'success')
    {
        $this->messages[] = [
            'message' => $message,
            'type' => $type,
            'title' => ucfirst($type),
            'time' => now()->format('H:i:s'),
            'icon' => $type == 'success' ? 'fi-rs-check' : 'fi-rs-cross',
        ];
    }

    public function closeToast($index)
    {
        unset($this->messages[$index]);
    }

    public function render()
    {
        return view('livewire.toast');
    }
}
