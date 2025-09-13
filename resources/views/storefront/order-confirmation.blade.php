<x-storefront-layout title="Order Confirmation">
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}" rel="nofollow">Home</a>
                    <span></span> Shop
                    <span></span> Order Confirmation
                </div>
            </div>
        </div>

        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center">
                            <div class="mb-50">
                                <i class="fi-rs-check-circle text-success" style="font-size: 80px;"></i>
                            </div>
                            <h2 class="mb-30">Thank you for your order!</h2>
                            <p class="text-muted mb-30">Your order has been placed successfully. We'll send you a
                                confirmation email shortly.</p>

                            <div class="order-details bg-light p-30 rounded mb-50">
                                <h4 class="mb-20">Order Details</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Order Number:</strong> {{ $order->number }}</p>
                                        <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>
                                        <p><strong>Payment Status:</strong>
                                            <span
                                                class="badge badge-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                                                {{ ucfirst($order->payment_status) }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Order Status:</strong>
                                            <span class="badge badge-primary">{{ ucfirst($order->status) }}</span>
                                        </p>
                                        <p><strong>Total Amount:</strong> ${{ number_format($order->total, 2) }}</p>
                                        <p><strong>Payment Method:</strong>
                                            {{ ucfirst(str_replace('_', ' ', $order->meta['payment_method'] ?? 'N/A')) }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg mb-15">Continue
                                        Shopping</a>
                                    <br>
                                    <a href="{{ route('my-account') }}" class="text-muted">View Order History</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-storefront-layout>
