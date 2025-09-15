<div class="grid grid-cols-12 gap-4">
    <div class="col-span-12 space-y-4 lg:col-span-8">
        <div class="card">
            <div class="card-header flex justify-between">
                <h5>Order #{{ $order->number }}</h5>
                <div class="flex items-center gap-2">
                    <button class="btn btn-light btn-sm">Export
                        <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M7 7h10v10"></path>
                            <path d="M7 17 17 7"></path>
                        </svg>
                    </button>
                    <button class="btn btn-light btn-sm">
                        <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="1"></circle>
                            <circle cx="19" cy="12" r="1"></circle>
                            <circle cx="5" cy="12" r="1"></circle>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="card-body space-y-4">
                <div class="flex justify-between">
                    <p class="text-sm">Order placed:
                        {{ $order->formatted_placed_at }}
                    </p>
                    <div class="flex gap-2">
                        <span class="badge badge-pill bg-success-100 text-success">
                            {{ ucfirst($order->payment_status) }} </span>
                        <span class="badge badge-pill bg-warning-100 text-warning">{{ ucfirst($order->status) }}</span>
                    </div>
                </div>
                <hr />

                <div class="divide-y">
                    @foreach ($order->items as $item)
                        <div class="flex items-center gap-4 py-4">
                            <div class="h-24 w-24">
                                <img src="{{ $item->product?->thumbnail_path }}" alt="{{ $item->name }}"
                                    class="h-full w-full rounded-lg object-cover" />
                            </div>

                            <div class="grid w-full grid-cols-3 gap-4">
                                <div class="space-y-1">
                                    <p class="text-sm">Item</p>
                                    <p class="font-medium">{{ $item->name }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-sm">SKU</p>
                                    <p class="font-medium">{{ $item->sku ?? '-' }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-sm">Quantity</p>
                                    <p class="font-medium">{{ $item->quantity }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-sm">Unit Price</p>
                                    <p class="font-medium">{{ formatPrice($item->unit_price) }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-sm">Tax</p>
                                    <p class="font-medium">{{ formatPrice($item->tax_total) }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-sm">Line Total</p>
                                    <p class="font-medium">{{ formatPrice($item->total) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <hr />

                <div class="md:grid md:grid-cols-2">
                    <div>
                        <p class="text-sm">Order Summary</p>
                        @if ($order->customer_note)
                            <p class="mt-1 text-xs text-neutral-600">Note: {{ $order->customer_note }}</p>
                        @endif
                    </div>
                    <div class="flex max-w-md flex-col justify-end rounded-lg">
                        <div class="space-y-4 text-sm">
                            <div class="flex justify-between">
                                <p>Subtotal:</p>
                                <p class="font-medium">{{ formatPrice($order->subtotal) }}</p>
                            </div>
                            <div class="flex justify-between">
                                <p>Discounts:</p>
                                <p class="font-medium">- {{ formatPrice($order->discount_total) }}</p>
                            </div>
                            <div class="flex justify-between">
                                <p>Shipping:</p>
                                <p class="font-medium">{{ formatPrice($order->shipping_total) }}</p>
                            </div>
                            <div class="flex justify-between">
                                <p>Tax:</p>
                                <p class="font-medium">{{ formatPrice($order->tax_total) }}</p>
                            </div>
                            <div class="flex justify-between text-lg font-bold">
                                <p>Order total:</p>
                                <p>{{ formatPrice($order->total) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer flex items-center justify-between">
                <button wire:click="goToPrevious" class="btn btn-light btn-sm" title="Previous order"
                    wire:loading.attr="disabled" wire:target="goToPrevious">
                    <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6"></path>
                    </svg>
                    Prev
                </button>
                <p class="text-sx">Placed: {{ $order->formatted_placed_at }}</p>
                <button wire:click="goToNext" class="btn btn-light btn-sm" title="Next order"
                    wire:loading.attr="disabled" wire:target="goToNext">
                    Next
                    <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div class="card">
            <div class="card-header flex justify-between">
                <h5>Timeline</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled timeline-widget mb-0">
                    <li class="ti-list-group timeline-widget-list w-full border-0 p-0">
                        <div class="flex w-full">
                            <div class="text-center ltr:mr-12 rtl:ml-12">
                                <span class="block text-sm font-semibold">Now</span>
                            </div>
                            <div class="w-full">
                                <div>
                                    <div class="quill-editor"></div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-span-12 space-y-4 lg:col-span-4">
        <div class="card">
            <div class="card-header">
                <h5>Customer</h5>
            </div>
            <div class="card-body p-2">
                <div class="p-2">
                    <div class="border-t pt-3">
                        <div class="flex justify-between">
                            <p class="font-semibold">Contact info</p>
                        </div>
                        <p class="mt-2 text-sm">
                            @if ($order->customer)
                                <span class="block">{{ $order->customer->first_name }}
                                    {{ $order->customer->last_name }}</span>
                                <span class="block">✉️ {{ $order->customer->email }}</span>
                                <span class="block">📞 {{ $order->customer->phone ?? '-' }}</span>
                            @else
                                <span class="block">Guest checkout</span>
                            @endif
                        </p>
                    </div>

                    <div class="mt-3 border-t pt-3">
                        <div class="flex justify-between">
                            <p class="font-semibold">Shipping address</p>
                        </div>
                        <address class="mt-2 text-sm">
                            {!! $order->formattedShippingAddress() !!}
                        </address>
                    </div>

                    <div class="mt-3 border-t pt-3">
                        <div class="flex justify-between">
                            <p class="font-semibold">Billing address</p>
                        </div>
                        <address class="mt-2 text-sm">
                            {!! $order->formattedBillingAddress() !!}
                        </address>
                    </div>

                    <div class="mt-3 border-t pt-3">
                        <p class="font-semibold">Payment</p>
                        <p class="mt-2 text-sm">Status: {{ ucfirst($order->payment_status) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
