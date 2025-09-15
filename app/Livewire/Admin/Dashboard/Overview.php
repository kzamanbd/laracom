<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Core\Customer;
use App\Models\Orders\Order;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Overview extends Component
{
    #[Computed]
    public function totalRevenue(): float
    {
        $revenue = Order::query()
            ->whereIn('status', ['paid', 'processing', 'shipped', 'completed'])
            ->sum('total');

        return (float) $revenue;
    }

    #[Computed]
    public function totalOrders(): int
    {
        return (int) Order::query()->count();
    }

    #[Computed]
    public function averageOrderValue(): float
    {
        $orders = $this->totalOrders();
        $revenue = (float) $this->totalRevenue();

        if ($orders === 0) {
            return 0.0;
        }

        return $revenue / $orders;
    }

    #[Computed]
    public function totalCustomers(): int
    {
        return (int) Customer::query()->count();
    }

    #[Computed]
    public function todayOrders(): int
    {
        return (int) Order::query()
            ->whereDate('created_at', Carbon::today())
            ->count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard.overview');
    }
}
