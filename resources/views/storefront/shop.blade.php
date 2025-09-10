<x-storefront-layout title="Shop">
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}" rel="nofollow">Home</a>
                    <span></span> Shop
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                @livewire('storefront.shop')
            </div>
        </section>
    </main>
    @livewire('storefront.product.quick-view')
</x-storefront-layout>
