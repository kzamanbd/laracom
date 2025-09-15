<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Orders\Order;
use Carbon\CarbonPeriod;
use Livewire\Attributes\Computed;
use Livewire\Component;

class SalesTrend extends Component
{
    #[Computed]
    public function series(): array
    {
        $period = CarbonPeriod::create(now()->subDays(29)->startOfDay(), now()->startOfDay());

        $dates = collect($period)->map(fn ($d) => $d->format('Y-m-d'));

        $rows = Order::query()
            ->selectRaw('DATE(created_at) as d, COUNT(*) as orders, SUM(total) as revenue')
            ->whereDate('created_at', '>=', now()->subDays(29)->startOfDay())
            ->groupBy('d')
            ->orderBy('d')
            ->get()
            ->keyBy('d');

        $orders = [];
        $revenue = [];

        foreach ($dates as $d) {
            $orders[] = (int) ($rows[$d]->orders ?? 0);
            $revenue[] = (float) ($rows[$d]->revenue ?? 0);
        }

        return [
            'labels' => $dates->values()->all(),
            'orders' => $orders,
            'revenue' => $revenue,
        ];
    }

    public function render()
    {
        return view('livewire.admin.dashboard.sales-trend');
    }
}
