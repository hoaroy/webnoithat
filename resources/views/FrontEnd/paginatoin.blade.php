@if ($paginator->hasPages())
    <!-- Pagination -->
    <label>Page:</label>
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li>
                <a href="#">&laquo;</a>
            </li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}">&laquo;</a>
            </li>
        @endif
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><a>{{ $page }}</a></li>
                    @elseif (($page == $paginator->currentPage() + 1 || $page == $paginator->currentPage() + 2) || $page == $paginator->lastPage())
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @elseif ($page == $paginator->lastPage() - 1)
                        <li class="disabled"><a><i class="fa fa-ellipsis-h"></i></a></li>
                    @endif
                @endforeach
            @endif
        @endforeach
        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}">&raquo;</a>
            </li>
        @else
        <li><a href="#">&raquo;</a></li>
        @endif
    </ul>
    <!-- Pagination -->
@endif
