<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home') }}" rel="nofollow">Home</a>
                <span></span> <a href="{{ route('my-account') }}">My Account</a>
                <span></span> Order #{{ $order->number }}
            </div>
        </div>
    </div>

    <section class="pt-150 pb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @error('order')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @enderror

                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">Order #{{ $order->number }}</h4>
                                <small class="text-muted">
                                    Placed on {{ $order->created_at->format('F d, Y \a\t g:i A') }}
                                    @if ($order->placed_at)
                                        • Confirmed: {{ $order->placed_at->format('F d, Y \a\t g:i A') }}
                                    @endif
                                </small>
                            </div>
                            <div class="text-end">
                                <span class="badge {{ $this->getStatusBadgeClass() }} me-2">
                                    {{ ucfirst($order->status) }}
                                </span>
                                <span class="badge {{ $this->getPaymentStatusBadgeClass() }}">
                                    Payment {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                        </div>

                        <div class="card-body">
                            <!-- Order Actions -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('my-account', ['tab' => 'orders']) }}"
                                            class="btn btn-outline-secondary">
                                            <i class="fi-rs-arrow-left"></i> Back to Orders
                                        </a>
                                        @if ($order->canBeCancelled())
                                            <button type="button" class="btn btn-outline-danger"
                                                wire:click="cancelOrder"
                                                onclick="return confirm('Are you sure you want to cancel this order?')">
                                                Cancel Order
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="row">
                                <div class="col-lg-8">
                                    <h5 class="mb-3">Order Items</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Product</th>
                                                    <th>SKU</th>
                                                    <th>Price</th>
                                                    <th>Qty</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->items as $item)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                @if ($item->product && $item->product->image)
                                                                    <img src="{{ $item->product->image }}"
                                                                        alt="{{ $item->name }}" class="me-3"
                                                                        style="width: 50px; height: 50px; object-fit: cover;">
                                                                @endif
                                                                <div>
                                                                    <h6 class="mb-0">{{ $item->name }}</h6>
                                                                    @if ($item->product)
                                                                        <small class="text-muted">
                                                                            <a href="{{ route('product', $item->product->slug ?? '#') }}"
                                                                                class="text-decoration-none">
                                                                                View Product
                                                                            </a>
                                                                        </small>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><code>{{ $item->sku }}</code></td>
                                                        <td>${{ number_format($item->unit_price, 2) }}</td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td class="fw-bold">${{ number_format($item->total, 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    @if ($order->customer_note)
                                        <div class="mt-4">
                                            <h6>Customer Note</h6>
                                            <div class="bg-light p-3 rounded">
                                                {{ $order->customer_note }}
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Order Summary -->
                                <div class="col-lg-4">
                                    <div class="card bg-light">
                                        <div class="card-header">
                                            <h6 class="mb-0">Order Summary</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Subtotal:</span>
                                                <span>${{ number_format($order->subtotal, 2) }}</span>
                                            </div>
                                            @if ($order->discount_total > 0)
                                                <div class="d-flex justify-content-between mb-2 text-success">
                                                    <span>Discount:</span>
                                                    <span>-${{ number_format($order->discount_total, 2) }}</span>
                                                </div>
                                            @endif
                                            @if ($order->tax_total > 0)
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Tax:</span>
                                                    <span>${{ number_format($order->tax_total, 2) }}</span>
                                                </div>
                                            @endif
                                            @if ($order->shipping_total > 0)
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Shipping:</span>
                                                    <span>${{ number_format($order->shipping_total, 2) }}</span>
                                                </div>
                                            @endif
                                            <hr>
                                            <div class="d-flex justify-content-between fw-bold fs-5">
                                                <span>Total:</span>
                                                <span>${{ number_format($order->total, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Billing Address -->
                                    @if ($order->billingAddress)
                                        <div class="card mt-3">
                                            <div class="card-header">
                                                <h6 class="mb-0">Billing Address</h6>
                                            </div>
                                            <div class="card-body">
                                                <address class="mb-0">
                                                    @if ($order->billingAddress->company)
                                                        <strong>{{ $order->billingAddress->company }}</strong><br>
                                                    @endif
                                                    @if ($order->billingAddress->name)
                                                        {{ $order->billingAddress->name }}<br>
                                                    @endif
                                                    {{ $order->billingAddress->line1 }}<br>
                                                    @if ($order->billingAddress->line2)
                                                        {{ $order->billingAddress->line2 }}<br>
                                                    @endif
                                                    {{ $order->billingAddress->city }}, {{ $order->billingAddress->state }} {{ $order->billingAddress->postal_code }}<br>
                                                    {{ $order->billingAddress->country }}
                                                    @if ($order->billingAddress->phone)
                                                        <br>Phone: {{ $order->billingAddress->phone }}
                                                    @endif
                                                </address>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Shipping Address -->
                                    @if ($order->shippingAddress)
                                        <div class="card mt-3">
                                            <div class="card-header">
                                                <h6 class="mb-0">Shipping Address</h6>
                                            </div>
                                            <div class="card-body">
                                                <address class="mb-0">
                                                    @if ($order->shippingAddress->company)
                                                        <strong>{{ $order->shippingAddress->company }}</strong><br>
                                                    @endif
                                                    @if ($order->shippingAddress->name)
                                                        {{ $order->shippingAddress->name }}<br>
                                                    @endif
                                                    {{ $order->shippingAddress->line1 }}<br>
                                                    @if ($order->shippingAddress->line2)
                                                        {{ $order->shippingAddress->line2 }}<br>
                                                    @endif
                                                    {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }} {{ $order->shippingAddress->postal_code }}<br>
                                                    {{ $order->shippingAddress->country }}
                                                    @if ($order->shippingAddress->phone)
                                                        <br>Phone: {{ $order->shippingAddress->phone }}
                                                    @endif
                                                </address>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Payment Information -->
                                    @if ($order->paymentTransactions->count() > 0)
                                        <div class="card mt-3">
                                            <div class="card-header">
                                                <h6 class="mb-0">Payment Information</h6>
                                            </div>
                                            <div class="card-body">
                                                @foreach ($order->paymentTransactions as $transaction)
                                                    <div class="mb-2">
                                                        <small
                                                            class="text-muted">{{ $transaction->created_at->format('M d, Y g:i A') }}</small><br>
                                                        <span class="fw-bold">Payment</span>:
                                                        ${{ number_format($transaction->amount, 2) }}
                                                        <span
                                                            class="badge bg-{{ $transaction->status === 'succeeded' ? 'success' : ($transaction->status === 'initiated' ? 'warning' : 'danger') }} ms-2">
                                                            {{ ucfirst($transaction->status) }}
                                                        </span>
                                                        @if ($transaction->provider)
                                                            <br><small class="text-muted">via {{ ucfirst($transaction->provider) }}</small>
                                                        @endif
                                                        @if ($transaction->reference)
                                                            <br><small class="text-muted">Ref: {{ $transaction->reference }}</small>
                                                        @endif
                                                    </div>
                                                    @if (!$loop->last)
                                                        <hr>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
