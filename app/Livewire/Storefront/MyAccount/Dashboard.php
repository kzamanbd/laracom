<?php

namespace App\Livewire\Storefront\MyAccount;

use App\Livewire\Actions\Logout;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.storefront', ['title' => 'My Account'])]
class Dashboard extends Component
{
    use WithPagination;

    public $queryString = ['tab' => ['except' => '']];

    public $tab = 'dashboard';

    public function setTab($tab)
    {
        $this->tab = $tab;
    }

    public function logout(Logout $logout)
    {
        $logout();

        return redirect()->route('home');
    }

    /**
     * Get user's recent orders
     */
    #[Computed]
    public function recentOrders(): Collection
    {
        return auth()->user()->ordersWithDetails()
            ->limit(5)
            ->get();
    }

    /**
     * Get all user's orders
     */
    #[Computed]
    public function orders()
    {
        return auth()->user()->ordersWithDetails()->paginate(10);
    }

    /**
     * Get all user's orders (non-paginated)
     */
    #[Computed]
    public function allOrders(): Collection
    {
        return auth()->user()->ordersWithDetails()->get();
    }

    /**
     * Get user's full name from customer or user model
     */
    #[Computed]
    public function userName(): string
    {
        $user = auth()->user();

        // Try to get name from customer first
        if ($user->customer) {
            return $user->customer->full_name;
        }

        // Fallback to user name
        return $user->name ?? 'User';
    }

    public function render()
    {
        return view('livewire.storefront.my-account.dashboard');
    }
}
