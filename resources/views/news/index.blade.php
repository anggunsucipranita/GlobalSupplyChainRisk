@extends('layouts.master')

@section('content')

<h2 class="mb-4 fw-bold text-light">
    📰 Global News
</h2>

@if(count($news))

    @foreach($news as $item)

        <div class="card bg-dark text-light border-secondary mb-3">
            <div class="card-body">

                <h5>{{ $item['title'] }}</h5>

                <p>{{ $item['description'] }}</p>

                <a href="{{ $item['url'] }}" target="_blank" class="btn btn-primary">
                    Read More
                </a>

            </div>
        </div>

    @endforeach

@else

    <div class="alert alert-warning">
        Tidak ada berita.
    </div>

@endif

@endsection