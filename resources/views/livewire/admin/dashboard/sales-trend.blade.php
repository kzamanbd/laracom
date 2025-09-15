<div class="bg-white dark:bg-gray-800 shadow-xs rounded-lg p-5">
    <div class="flex items-center justify-between">
        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Sales (30 days)</h3>
    </div>
    <div class="mt-4">
        <div class="text-sm text-gray-500 dark:text-gray-400">Orders: {{ collect($this->series['orders'])->sum() }}</div>
        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            Revenue: {{ formatPrice(collect($this->series['revenue'])->sum()) }}
        </div>
    </div>
    <div class="mt-4 text-xs text-gray-400 dark:text-gray-500">
        <!-- Placeholder: integrate chart library later -->
        <div class="h-60 bg-gray-50 dark:bg-gray-900/30 rounded"></div>
    </div>
</div>
