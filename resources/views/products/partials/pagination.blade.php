@if ($paginator->hasPages())
<div class="container mt-4">
    <div class="w-100 d-flex flex-column align-items-center gap-2 text-center">
        <div class="text-muted small">
            Showing {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        </div>

        <nav id="pagination-container">
            <ul class="pagination mb-0 flex-wrap justify-content-center">


                @if ($paginator->currentPage() >= 7)
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url(1) }}" aria-label="First">
                        1
                    </a>
                </li>
                @endif

                <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() ?? '#' }}" aria-label="Previous">&laquo;</a>
                </li>

                @foreach ($paginator->getUrlRange(max(1, $paginator->currentPage() - 5), min($paginator->lastPage(), $paginator->currentPage() + 5)) as $page => $url)
                <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
                @endforeach

                <li class="page-item {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() ?? '#' }}" aria-label="Next">&raquo;</a>
                </li>

            </ul>
        </nav>
    </div>
</div>
@endif