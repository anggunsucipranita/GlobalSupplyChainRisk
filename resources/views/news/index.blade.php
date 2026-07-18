@extends('layouts.master')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold text-light">
                📰 News Intelligence
            </h2>

            <p class="text-secondary mb-0">
                Latest Global Logistics • Trade • Shipping • Economy News
            </p>

        </div>

    </div>


    {{-- SEARCH --}}
    <form method="GET" class="mb-4">

        <div class="input-group">

            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Search country or topic..."
                value="{{ $keyword ?? '' }}">

            <button
                class="btn btn-primary"
                type="submit">

                <i class="bi bi-search"></i>

                Search

            </button>

        </div>

    </form>


    @if($news->count())


    <div class="row">


        @foreach($news as $item)


        <div class="col-lg-6 mb-4">


            <div class="card bg-dark border-secondary shadow h-100">


                {{-- IMAGE --}}
                @if($item->image)

                    <img
                        src="{{ $item->image }}"
                        class="card-img-top"
                        style="height:220px;object-fit:cover;">

                @else

                    <img
                        src="https://placehold.co/600x350/1f2937/ffffff?text=NEWS"
                        class="card-img-top"
                        style="height:220px;object-fit:cover;">

                @endif



                <div class="card-body d-flex flex-column">


                    {{-- SOURCE + DATE --}}
                    <div class="d-flex justify-content-between mb-3">


                        <small class="text-info fw-semibold">

                            📰 {{ $item->source ?? 'Unknown Source' }}

                        </small>


                        <small class="text-secondary">

                            {{ $item->published_at
                                ? $item->published_at->format('d M Y H:i')
                                : '-'
                            }}

                        </small>


                    </div>



                    {{-- TITLE --}}
                    <h5 class="fw-bold text-light mb-3">

                        {{ $item->title }}

                    </h5>



                    {{-- DESCRIPTION --}}
                    <p class="text-secondary flex-grow-1">

                        {{ \Illuminate\Support\Str::limit($item->description,150) }}

                    </p>




                    {{-- SENTIMENT --}}
                    <div class="mb-3">


                        @if($item->sentiment == "Positive")


                            <span class="badge bg-success">

                                😊 Positive

                            </span>


                        @elseif($item->sentiment == "Negative")


                            <span class="badge bg-danger">

                                😡 Negative

                            </span>


                        @else


                            <span class="badge bg-warning text-dark">

                                😐 Neutral

                            </span>


                        @endif


                    </div>




                    {{-- SCORE --}}
                    <div class="row text-center mb-3">


                        <div class="col-4">


                            <h5 class="text-success mb-1">

                                {{ $item->positive }}

                            </h5>


                            <small class="text-secondary">

                                Positive

                            </small>


                        </div>



                        <div class="col-4">


                            <h5 class="text-danger mb-1">

                                {{ $item->negative }}

                            </h5>


                            <small class="text-secondary">

                                Negative

                            </small>


                        </div>



                        <div class="col-4">


                            <h5 class="text-info mb-1">

                                {{ $item->sentiment }}

                            </h5>


                            <small class="text-secondary">

                                Result

                            </small>


                        </div>


                    </div>




                    {{-- BUTTON --}}
                    <a
                        href="{{ $item->url }}"
                        target="_blank"
                        class="btn btn-primary w-100">


                        <i class="bi bi-box-arrow-up-right"></i>

                        Read Full Article


                    </a>


                </div>


            </div>


        </div>


        @endforeach


    </div>


    {{-- PAGINATION --}}
    <div class="mt-4">

        {{ $news->links() }}

    </div>



    @else


    <div class="alert alert-warning">

        <i class="bi bi-exclamation-circle"></i>

        No news found.

    </div>


    @endif


</div>


@endsection