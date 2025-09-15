<div class="bg-white dark:bg-gray-800 shadow-xs rounded-lg p-5">
    <div class="flex items-center justify-between">
        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Orders</h3>
    </div>

    <div class="mt-4 overflow-x-auto">
        <table class="min-w-full text-left text-sm">
            <thead class="text-gray-500 dark:text-gray-400">
                <tr>
                    <th class="py-2 px-4 bg-gray-100">Order</th>
                    <th class="py-2 pr-4 bg-gray-100">Status</th>
                    <th class="py-2 pr-4 bg-gray-100">Payment</th>
                    <th class="py-2 pr-4 bg-gray-100">Total</th>
                    <th class="py-2 pr-4 bg-gray-100">Placed</th>
                </tr>
            </thead>
            <tbody class="text-gray-900 dark:text-gray-100">
                @forelse ($this->orders as $order)
                    <tr class="border-t border-gray-100 dark:border-gray-700/50">
                        <td class="py-2 pr-4 font-medium">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-primary hover:underline"
                                wire:navigate>
                                {{ $order->number }}
                            </a>
                        </td>
                        <td class="py-2 pr-4">
                            <span class="px-2 py-1 rounded text-xs bg-gray-100 dark:bg-gray-900/40">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="py-2 pr-4 text-xs">{{ ucfirst($order->payment_status) }}</td>
                        <td class="py-2 pr-4">{{ formatPrice($order->total) }}</td>
                        <td class="py-2 pr-4 text-xs">{{ $order->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center text-gray-500 dark:text-gray-400">No orders
                            found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $this->orders->links() }}
    </div>
</div>
