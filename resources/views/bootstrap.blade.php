@if (count($trail))
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            @foreach ($trail as $crumb)
                @if ($loop->last)
                    <li class="breadcrumb-item active" aria-current="page">{{ $crumb->title() }}</li>
                @else
                    <li class="breadcrumb-item"><a href="{{ $crumb->url() }}">{{ $crumb->title() }}</a></li>
                @endif
            @endforeach
        </ol>
    </nav>
@endif