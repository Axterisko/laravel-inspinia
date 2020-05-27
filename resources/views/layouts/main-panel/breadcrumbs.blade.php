@if ($breadcrumbs)
    <ol class="breadcrumb">
        @foreach ($breadcrumbs as $breadcrumb)
            @if ($loop->last)
                <li class="breadcrumb-item active"><strong>{{ $breadcrumb->title }}</strong></li>
            @else
                <li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
            @endif
        @endforeach
    </ol>
@endif
