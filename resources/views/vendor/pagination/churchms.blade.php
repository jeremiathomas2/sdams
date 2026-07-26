@if ($paginator->hasPages())
<div class="pager">
    <div class="pager-info">
        @if ($paginator->total() > 0)
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        @else
            Showing 0 results
        @endif
    </div>

    <nav class="pager-nav" aria-label="Pagination">
        <ul class="pager-list">
            @if ($paginator->onFirstPage())
                <li><span class="pager-link disabled" aria-disabled="true">Previous</span></li>
            @else
                <li><a class="pager-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">Previous</a></li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span class="pager-ellipsis" aria-hidden="true">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><span class="pager-link active" aria-current="page">{{ $page }}</span></li>
                        @else
                            <li><a class="pager-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li><a class="pager-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a></li>
            @else
                <li><span class="pager-link disabled" aria-disabled="true">Next</span></li>
            @endif
        </ul>
    </nav>
</div>
@endif
