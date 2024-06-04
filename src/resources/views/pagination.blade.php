@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true"><span>&lt;</span></li>
            @else
                <li><button class="prev-page" wire:click="previousPage" wire:loading.attr="disabled" rel="prev">&lt;</button></li>
            @endif

            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active" aria-current="page"><span>{{ $page }}</span></li>
                        @else
                            <li><button wire:click="gotoPage({{ $page }})" class="page-link">{{ $page }}</button></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li><button class="next-page" wire:click="nextPage" wire:loading.attr="disabled" rel="next">&gt;</button></li>
            @else
                <li class="disabled" aria-disabled="true"><span>&gt;</span></li>
            @endif
        </ul>
    </nav>
@endif
