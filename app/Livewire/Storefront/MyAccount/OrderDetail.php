<?php

namespace App\Livewire\Storefront\MyAccount;

use App\Models\Order;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.storefront', ['title' => 'Order Details'])]
class OrderDetail extends Component
{
    public Order $order;

    public function mount(Order $order): void
    {
        // Ensure the user can only view their own orders
        if (Gate::denies('view', $order)) {
            abort(403, 'You are not authorized to view this order.');
        }

        $this->order = $order->load([
            'items.product.thumbnail',
            'customer',
            'billingAddress',
            'shippingAddress',
            'paymentTransactions',
        ]);
    }

    /**
     * Get the order status badge class
     */
    public function getStatusBadgeClass(): string
    {
        return match ($this->order->status) {
            'completed' => 'bg-success',
            'paid' => 'bg-info',
            'processing' => 'bg-warning',
            'cancelled' => 'bg-danger',
            default => 'bg-secondary',
        };
    }

    /**
     * Get the payment status badge class
     */
    public function getPaymentStatusBadgeClass(): string
    {
        return match ($this->order->payment_status) {
            'paid' => 'bg-success',
            'partially_refunded' => 'bg-warning',
            'refunded' => 'bg-info',
            'unpaid' => 'bg-secondary',
            default => 'bg-secondary',
        };
    }

    /**
     * Cancel the order if allowed
     */
    public function cancelOrder(): void
    {
        if (! $this->order->canBeCancelled()) {
            $this->addError('order', 'This order cannot be cancelled.');

            return;
        }

        $this->order->update([
            'status' => 'cancelled',
        ]);

        session()->flash('success', 'Order has been cancelled successfully.');
        $this->redirectRoute('my-account', ['tab' => 'orders']);
    }

    public function render()
    {
        return view('livewire.storefront.my-account.order-detail');
    }
}
