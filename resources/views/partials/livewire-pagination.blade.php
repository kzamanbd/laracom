@if ($paginator->hasPages())
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-start">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link"><i class="fi-rs-angle-double-small-left"></i></span>
                </li>
            @else
                <li class="page-item">
                    <button type="button" class="page-link" wire:click="previousPage" wire:loading.attr="disabled"
                        rel="prev">
                        <i class="fi-rs-angle-double-small-left"></i>
                    </button>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled">
                        <span class="page-link dot">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <span class="page-link">
                                    {{ str_pad($page, 2, '0', STR_PAD_LEFT) }}
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <button type="button" class="page-link" wire:click="gotoPage({{ $page }})"
                                    wire:loading.attr="disabled" wire:key="page-{{ $page }}">
                                    {{ str_pad($page, 2, '0', STR_PAD_LEFT) }}
                                </button>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <button type="button" class="page-link" wire:click="nextPage" wire:loading.attr="disabled"
                        rel="next">
                        <i class="fi-rs-angle-double-small-right"></i>
                    </button>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link"><i class="fi-rs-angle-double-small-right"></i></span>
                </li>
            @endif
        </ul>
    </nav>
@endif
