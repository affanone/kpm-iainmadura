@if ($paginator->hasPages())
    <ul class="pagination justify-content-center">

        @if ($paginator->onFirstPage())
            <!-- <li class="disabled"><span>← Previous</span></li> -->
            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
        @else
            <!-- <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">← Previous</a></li> -->
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">Previous</a></li>
        @endif



        @foreach ($elements as $element)
            @if (is_string($element))
                <!-- <li class="disabled"><span>{{ $element }}</span></li> -->
                <li class="page-item disabled"><a class="page-link" href="#">{{ $element }}</a></li>
            @endif



            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <!-- <li class="active my-active"><span>{{ $page }}</span></li> -->
                        <li class="page-item active"><a class="page-link" href="#">{{ $page }}</a></li>
                    @else
                        <!-- <li><a href="{{ $url }}">{{ $page }}</a></li> -->
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach



        @if ($paginator->hasMorePages())
            <!-- <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">Next →</a></li> -->
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}">Next</a></li>
        @else
            <!-- <li class="disabled"><span>Next →</span></li> -->
            <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
        @endif
    </ul>
@endif
