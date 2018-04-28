@if ($paginator->hasPages())
    <div class="pagination">

      {{-- First Page Elements --}}
      @if ($paginator->onFirstPage())
        <div class="first">
          <a>&laquo;&nbsp;{{__('message.first_page')}}</a>
        </div>
      @endif

      <div class="pages">
        {{-- Previous Page divnk --}}
        @if ($paginator->onFirstPage())
            <div class="arrow disabled"><span>&laquo;</span></div>
        @else
            <div class="arrow"><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></div>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <div class="disabled"><span>{{ $element }}</span></div>
            @endif

            {{-- Array Of divnks --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <div class="page active"><span>{{ $page }}</span></div>
                    @else
                        <div class="page"><a href="{{ $url }}">{{ $page }}</a></div>
                    @endif
                @endforeach
            @endif

        @endforeach

        {{-- Next Page divnk --}}
        @if ($paginator->hasMorePages())
            <div class="arrow"><a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></div>
        @else
            <div class="arrow disabled"><span>&raquo;</span></div>
        @endif
      </div>
      {{-- Last Page Elements --}}
      @if ($paginator->hasMorePages())
        <div class="last">
          <a>{{__('message.last_page')}}&nbsp;&raquo;</a>
        </div>
      @endif

    </div>
@endif
