@extends('layouts.master')

@section('content')

<h2 class="mb-4 fw-bold text-light">
    🌍 Countries Data
</h2>

<div class="row g-3">

@forelse($countries as $country)

    @if(is_array($country) && isset($country['name']['common']))

        <div class="col-lg-3 col-md-4 col-sm-6">

            <div class="card bg-dark text-light border-secondary h-100 shadow-sm">

                <div class="card-body">

                    <div class="d-flex align-items-center mb-3">

                        <img
                            src="{{ $country['flags']['png'] ?? '' }}"
                            alt="Flag"
                            width="45"
                            class="rounded me-3">

                        <div>

                            <h5 class="mb-0">
                                {{ $country['name']['common'] }}
                            </h5>

                            <small class="text-secondary">
                                {{ $country['cca2'] ?? '-' }}
                            </small>

                        </div>

                    </div>

                    <p class="mb-2">
                        🌍 <strong>Region :</strong>
                        {{ $country['region'] ?? '-' }}
                    </p>

                    <p class="mb-2">
                        🏛 <strong>Capital :</strong>
                        {{ $country['capital'][0] ?? '-' }}
                    </p>

                    <p class="mb-0">
                        👥 <strong>Population :</strong>
                        {{ number_format($country['population'] ?? 0) }}
                    </p>

                </div>

            </div>

        </div>

    @endif

@empty

    <div class="col-12">

        <div class="alert alert-warning">

            Data negara tidak tersedia.

        </div>

    </div>

@endforelse

</div>

@endsection