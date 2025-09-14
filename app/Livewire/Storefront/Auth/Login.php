<?php

namespace App\Livewire\Storefront\Auth;

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Login extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        if (auth()->user()->hasRole('admin')) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $this->redirectIntended(default: route('home', absolute: false), navigate: true);
    }

    public function render()
    {
        return view('livewire.storefront.auth.login');
    }
}
