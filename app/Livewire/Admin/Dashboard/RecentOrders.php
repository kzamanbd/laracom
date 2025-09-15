<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Orders\Order;
use Livewire\Attributes\Computed;
use Livewire\Component;

class RecentOrders extends Component
{
    #[Computed]
    public function orders()
    {
        return Order::query()
            ->latest('created_at')
            ->limit(10)
            ->get(['id', 'number', 'status', 'payment_status', 'total', 'created_at']);
    }

    public function render()
    {
        return view('livewire.admin.dashboard.recent-orders');
    }
}
