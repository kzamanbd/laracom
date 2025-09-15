<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Orders\Order;
use Livewire\Component;

class OrderDetail extends Component
{
    public Order $order;

    public function mount(Order $order): void
    {
        $this->order = $order->load([
            'customer',
            'items.product.thumbnail',
            'billingAddress',
            'shippingAddress',
            'paymentTransactions',
        ]);
    }

    public function goToPrevious(): void
    {
        $previousId = Order::query()
            ->where('id', '<', $this->order->id)
            ->orderByDesc('id')
            ->value('id');

        if ($previousId) {
            $this->redirectRoute('admin.orders.show', $previousId);
        }
    }

    public function goToNext(): void
    {
        $nextId = Order::query()
            ->where('id', '>', $this->order->id)
            ->orderBy('id')
            ->value('id');

        if ($nextId) {
            $this->redirectRoute('admin.orders.show', $nextId);
        }
    }

    public function render()
    {
        return view('livewire.admin.orders.order-detail');
    }
}
