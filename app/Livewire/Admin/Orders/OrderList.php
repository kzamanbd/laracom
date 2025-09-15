<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Orders\Order;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class OrderList extends Component
{
    use WithPagination;

    public int $perPage = 15;

    #[Computed]
    public function orders()
    {
        return Order::query()
            ->latest('created_at')
            ->select(['id', 'number', 'status', 'payment_status', 'total', 'created_at'])
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.admin.orders.order-list');
    }
}
