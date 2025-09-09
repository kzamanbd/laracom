<div class="header-action-icon-2">
    <a class="mini-cart-icon" href="{{ route('cart') }}">
        <img alt="DraftScripts" src="{{ asset('assets/imgs/theme/icons/icon-cart.svg') }}">
        <span class="pro-count blue">{{ $this->itemCount }}</span>
    </a>
    <div class="cart-dropdown-wrap cart-dropdown-hm2">
        @if ($cart->items->count() > 0)
            <ul>
                @foreach ($cart->items as $item)
                    <li wire:key="cart-item-{{ $item->id }}" class="d-flex align-items-center">
                        <div class="shopping-cart-img">
                            <a href="{{ $this->getProductUrl($item->product) }}">
                                <img alt="{{ $item->product_name }}"
                                    src="{{ $this->getProductThumbnail($item->product) }}">
                            </a>
                        </div>
                        <div class="shopping-cart-title text-truncate" style="max-width: 150px;">
                            <h4>
                                <a href="{{ $this->getProductUrl($item->product) }}">{{ $item->product_name }}</a>
                            </h4>
                            <h4><span>{{ $item->quantity }} × </span>{{ formatPrice($item->unit_price) }}</h4>
                        </div>
                        <div class="shopping-cart-delete">
                            <a href="#" wire:click="removeItem({{ $item->id }})"
                                wire:confirm="Are you sure you want to remove this item?">
                                <i class="fi-rs-cross-small"></i>
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="shopping-cart-footer">
                <div class="shopping-cart-total">
                    <h4>Total <span>{{ formatPrice($cart->total) }}</span></h4>
                </div>
                <div class="shopping-cart-button">
                    <a href="{{ route('cart') }}" class="outline">View cart</a>
                    <a href="{{ route('checkout') }}">Checkout</a>
                </div>
            </div>
        @else
            <div class="shopping-cart-empty text-center p-4">
                <p>Your cart is empty</p>
                <a href="{{ route('shop') }}" class="btn btn-sm">Continue Shopping</a>
            </div>
        @endif
    </div>
</div>
