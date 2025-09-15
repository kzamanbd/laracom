<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white dark:bg-gray-800 shadow-xs rounded-lg p-5">
        <div class="text-sm text-gray-500 dark:text-gray-400">Revenue</div>
        <div class="mt-2 text-2xl font-semibold text-gray-900 dark:text-gray-100">
            {{ formatPrice($this->totalRevenue) }}
        </div>
    </div>
    <div class="bg-white dark:bg-gray-800 shadow-xs rounded-lg p-5">
        <div class="text-sm text-gray-500 dark:text-gray-400">Orders</div>
        <div class="mt-2 text-2xl font-semibold text-gray-900 dark:text-gray-100">
            {{ $this->totalOrders }}
        </div>
    </div>
    <div class="bg-white dark:bg-gray-800 shadow-xs rounded-lg p-5">
        <div class="text-sm text-gray-500 dark:text-gray-400">Average Order Value</div>
        <div class="mt-2 text-2xl font-semibold text-gray-900 dark:text-gray-100">
            {{ formatPrice($this->averageOrderValue) }}
        </div>
    </div>
    <div class="bg-white dark:bg-gray-800 shadow-xs rounded-lg p-5">
        <div class="text-sm text-gray-500 dark:text-gray-400">Customers</div>
        <div class="mt-2 text-2xl font-semibold text-gray-900 dark:text-gray-100">
            {{ $this->totalCustomers }}
        </div>
    </div>
</div>
