<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home') }}" rel="nofollow">Home</a>
                <span></span> My Account
            </div>
        </div>
    </div>
    <section class="pt-150 pb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 m-auto">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="dashboard-menu">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a wire:click="setTab('dashboard')" @class(['nav-link', 'active' => $tab === 'dashboard'])>
                                            <i class="fi-rs-settings-sliders mr-10"></i>
                                            Dashboard
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a wire:click="setTab('orders')" @class(['nav-link', 'active' => $tab === 'orders'])>
                                            <i class="fi-rs-shopping-bag mr-10"></i>
                                            Orders
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a wire:click="setTab('track-orders')" @class(['nav-link', 'active' => $tab === 'track-orders'])>
                                            <i class="fi-rs-shopping-cart-check mr-10"></i>
                                            Track Your Order
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a wire:click="setTab('address')" @class(['nav-link', 'active' => $tab === 'address'])>
                                            <i class="fi-rs-marker mr-10"></i>
                                            My Address
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a wire:click="setTab('account-detail')" @class(['nav-link', 'active' => $tab === 'account-detail'])>
                                            <i class="fi-rs-user mr-10"></i>
                                            Account details
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" wire:click="logout">
                                            <i class="fi-rs-sign-out mr-10"></i>
                                            Logout
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="tab-content dashboard-content">
                                @if ($tab === 'dashboard')
                                    <div class="tab-pane fade active show">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="mb-0">Hello {{ $this->userName }}! </h5>
                                            </div>
                                            <div class="card-body">
                                                <p>From your account dashboard. you can easily check &amp; view your
                                                    <a wire:click="setTab('orders')">recent
                                                        orders
                                                    </a>
                                                    , manage your
                                                    <a wire:click="setTab('address')">
                                                        shipping and billing addresses
                                                    </a>
                                                    and
                                                    <a wire:click="setTab('account-detail')">
                                                        edit your password and account details.
                                                    </a>
                                                </p>

                                                @if ($this->recentOrders->count() > 0)
                                                    <div class="mt-4">
                                                        <h6>Recent Orders</h6>
                                                        <div class="table-responsive">
                                                            <table class="table table-sm">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Order</th>
                                                                        <th>Date</th>
                                                                        <th>Status</th>
                                                                        <th>Total</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($this->recentOrders as $order)
                                                                        <tr>
                                                                            <td><span
                                                                                    class="fw-bold text-primary">#{{ $order->number }}</span>
                                                                            </td>
                                                                            <td>{{ $order->created_at->format('M d, Y') }}
                                                                            </td>
                                                                            <td>
                                                                                <span
                                                                                    class="badge bg-{{ $order->status === 'completed'
                                                                                        ? 'success'
                                                                                        : ($order->status === 'paid'
                                                                                            ? 'info'
                                                                                            : ($order->status === 'processing'
                                                                                                ? 'warning'
                                                                                                : 'secondary')) }}">
                                                                                    {{ ucfirst($order->status) }}
                                                                                </span>
                                                                            </td>
                                                                            <td class="fw-bold">
                                                                                ${{ number_format($order->total, 2) }}
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="text-center mt-3">
                                                            <a wire:click="setTab('orders')"
                                                                class="btn btn-sm btn-outline-primary">
                                                                View All Orders
                                                            </a>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="mt-4 text-center py-4">
                                                        <i class="fi-rs-shopping-bag"
                                                            style="font-size: 3rem; color: #ddd;"></i>
                                                        <h6 class="text-muted mt-2">No Orders Yet</h6>
                                                        <p class="text-muted">Start shopping to see your orders here!
                                                        </p>
                                                        <a href="{{ route('home') }}"
                                                            class="btn btn-primary btn-sm">Start
                                                            Shopping
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($tab === 'orders')
                                    <div class="tab-pane fade active show">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="mb-0">Your Orders</h5>
                                            </div>
                                            <div class="card-body">
                                                @if ($this->orders->count() > 0)
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Order</th>
                                                                    <th>Date</th>
                                                                    <th>Status</th>
                                                                    <th>Payment</th>
                                                                    <th>Items</th>
                                                                    <th>Total</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($this->orders as $order)
                                                                    <tr>
                                                                        <td>
                                                                            <span
                                                                                class="fw-bold text-primary">#{{ $order->number }}</span>
                                                                            @if ($order->placed_at)
                                                                                <br><small class="text-muted">Placed:
                                                                                    {{ $order->placed_at->format('M d, Y g:i A') }}</small>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{ $order->created_at->format('M d, Y') }}
                                                                        </td>
                                                                        <td>
                                                                            <span
                                                                                class="badge bg-{{ $order->status === 'completed'
                                                                                    ? 'success'
                                                                                    : ($order->status === 'paid'
                                                                                        ? 'info'
                                                                                        : ($order->status === 'processing'
                                                                                            ? 'warning'
                                                                                            : ($order->status === 'cancelled'
                                                                                                ? 'danger'
                                                                                                : 'secondary'))) }}">
                                                                                {{ ucfirst($order->status) }}
                                                                            </span>
                                                                        </td>
                                                                        <td>
                                                                            <span
                                                                                class="badge bg-{{ $order->payment_status === 'paid'
                                                                                    ? 'success'
                                                                                    : ($order->payment_status === 'pending'
                                                                                        ? 'warning'
                                                                                        : 'danger') }}">
                                                                                {{ ucfirst($order->payment_status) }}
                                                                            </span>
                                                                        </td>
                                                                        <td>
                                                                            {{ $order->items->count() }}
                                                                            item{{ $order->items->count() !== 1 ? 's' : '' }}
                                                                            @if ($order->items->count() > 0)
                                                                                <br><small
                                                                                    class="text-muted">{{ $order->items->sum('quantity') }}
                                                                                    total qty</small>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <span
                                                                                class="fw-bold">${{ number_format($order->total, 2) }}</span>
                                                                            @if ($order->subtotal != $order->total)
                                                                                <br><small class="text-muted">Subtotal:
                                                                                    ${{ number_format($order->subtotal, 2) }}</small>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <a href="#"
                                                                                class="btn-small d-block mb-1"
                                                                                wire:click="$dispatch('order-details', { orderId: {{ $order->id }} })">View</a>
                                                                            @if ($order->canBeCancelled())
                                                                                <a href="#"
                                                                                    class="btn-small btn-secondary d-block"
                                                                                    wire:click="$dispatch('cancel-order', { orderId: {{ $order->id }} })"
                                                                                    onclick="return confirm('Are you sure you want to cancel this order?')">Cancel</a>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    {{ $this->orders->links('livewire.pagination') }}
                                                @else
                                                    <div class="text-center py-5">
                                                        <i class="fi-rs-shopping-bag"
                                                            style="font-size: 4rem; color: #ddd;"></i>
                                                        <h5 class="text-muted mt-3">No Orders Found</h5>
                                                        <p class="text-muted">You haven't placed any orders yet. Start
                                                            shopping to see your orders here!</p>
                                                        <a href="{{ route('home') }}" class="btn btn-primary">Start
                                                            Shopping</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($tab === 'track-orders')
                                    <div class="tab-pane fade active show">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="mb-0">Orders tracking</h5>
                                            </div>
                                            <div class="card-body contact-from-area">
                                                <p>To track your order please enter your OrderID in the box below and
                                                    press "Track" button. This was given to you on your receipt and in
                                                    the confirmation email you should have received.</p>
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <form class="contact-form-style mt-30 mb-50" action="#"
                                                            method="post">
                                                            <div class="input-style mb-20">
                                                                <label>Order ID</label>
                                                                <input name="order-id"
                                                                    placeholder="Found in your order confirmation email"
                                                                    type="text" class="square">
                                                            </div>
                                                            <div class="input-style mb-20">
                                                                <label>Billing email</label>
                                                                <input name="billing-email"
                                                                    placeholder="Email you used during checkout"
                                                                    type="email" class="square">
                                                            </div>
                                                            <button class="submit submit-auto-width"
                                                                type="submit">Track</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($tab === 'address')
                                    <div class="tab-pane fade active show">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="card mb-3 mb-lg-0">
                                                    <div class="card-header">
                                                        <h5 class="mb-0">Billing Address</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <address>000 Interstate<br> 00 Business Spur,<br> Sault Ste.
                                                            <br>Marie, MI 00000
                                                        </address>
                                                        <p>New York</p>
                                                        <a href="#" class="btn-small">Edit</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="mb-0">Shipping Address</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <address>4299 Express Lane<br>
                                                            Sarasota, <br>FL 00000 USA <br>Phone: 1.000.000.0000
                                                        </address>
                                                        <p>Sarasota</p>
                                                        <a href="#" class="btn-small">Edit</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($tab === 'account-detail')
                                    <div class="tab-pane fade">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Account Details</h5>
                                            </div>
                                            <div class="card-body">
                                                <p>Already have an account? <a href="login.html">Log in instead!</a>
                                                </p>
                                                <form method="post" name="enq">
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label>First Name <span class="required">*</span></label>
                                                            <input required="" class="form-control square"
                                                                name="name" type="text">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Last Name <span class="required">*</span></label>
                                                            <input required="" class="form-control square"
                                                                name="phone">
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>Display Name <span class="required">*</span></label>
                                                            <input required="" class="form-control square"
                                                                name="dname" type="text">
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>Email Address <span
                                                                    class="required">*</span></label>
                                                            <input required="" class="form-control square"
                                                                name="email" type="email">
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>Current Password <span
                                                                    class="required">*</span></label>
                                                            <input required="" class="form-control square"
                                                                name="password" type="password">
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>New Password <span class="required">*</span></label>
                                                            <input required="" class="form-control square"
                                                                name="npassword" type="password">
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>Confirm Password <span
                                                                    class="required">*</span></label>
                                                            <input required="" class="form-control square"
                                                                name="cpassword" type="password">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn btn-fill-out submit"
                                                                name="submit" value="Submit">Save</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
