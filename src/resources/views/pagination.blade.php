@if ($paginator->hasPages())
    <nav>
        <div class="pagination">
            @if ($paginator->onFirstPage())
                <button class="page" disabled>&lt;</button>
            @else
                <button class="page" wire:click="previousPage" wire:loading.attr="disabled" rel="prev">&lt;</button>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <button class="page" disabled>{{ $element }}</button>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <button class="page active">{{ $page }}</button>
                        @else
                            <button class="page" wire:click="gotoPage({{ $page }})">{{ $page }}</button>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <button class="page" wire:click="nextPage" wire:loading.attr="disabled" rel="next">&gt;</button>
            @else
                <button class="page" disabled>&gt;</button>
            @endif
        </div>
    </nav>
@endif
