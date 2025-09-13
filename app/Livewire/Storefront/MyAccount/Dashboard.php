<?php

namespace App\Livewire\Storefront\MyAccount;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.storefront', ['title' => 'My Account'])]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.storefront.my-account.dashboard');
    }
}
