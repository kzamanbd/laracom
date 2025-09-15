<div class="bg-white dark:bg-gray-800 shadow-xs rounded-lg p-5">
    <div class="flex items-center justify-between">
        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Recent Orders</h3>
    </div>
    <div class="mt-4 overflow-x-auto">
        <table class="min-w-full text-left text-sm">
            <thead class="text-gray-500 dark:text-gray-400">
                <tr>
                    <th class="py-2 pr-4">Order</th>
                    <th class="py-2 pr-4">Status</th>
                    <th class="py-2 pr-4">Payment</th>
                    <th class="py-2 pr-4">Total</th>
                    <th class="py-2 pr-4">Placed</th>
                </tr>
            </thead>
            <tbody class="text-gray-900 dark:text-gray-100">
                @forelse ($this->orders as $order)
                    <tr class="border-t border-gray-100 dark:border-gray-700/50">
                        <td class="py-2 pr-4 font-medium">{{ $order->number }}</td>
                        <td class="py-2 pr-4"><span
                                class="px-2 py-1 rounded text-xs bg-gray-100 dark:bg-gray-900/40">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td class="py-2 pr-4 text-xs">{{ ucfirst($order->payment_status) }}</td>
                        <td class="py-2 pr-4">{{ formatPrice($order->total) }}</td>
                        <td class="py-2 pr-4 text-xs">{{ $order->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center text-gray-500 dark:text-gray-400">No orders yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
