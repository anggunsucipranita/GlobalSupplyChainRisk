@extends('layouts.master')

@section('content')

<h2 class="mb-4 fw-bold text-light">
    🌍 Global Country Dashboard
</h2>

<div class="input-group mb-4">

    <input
        type="text"
        id="searchCountry"
        class="form-control"
        placeholder="Search country...">

</div>

<div class="row g-3">

@forelse($countries as $country)

@if(is_array($country))

<div class="col-lg-4 col-md-6 country-card">

    <div class="card bg-dark text-light border-secondary shadow h-100">

        <div class="card-body">

            {{-- FLAG + COUNTRY --}}
            <div class="text-center mb-4">

                <img
                src="https://flagcdn.com/w160/{{ strtolower($country['cca2']) }}.png"
                alt="{{ $country['name']['common'] }}"
                width="90"
                class="rounded shadow mb-3">

                <h4 class="fw-bold text-info mb-1">

                    {{ $country['name']['common'] ?? '-' }}

                </h4>

                <small class="text-secondary">

                    {{ $country['cca3'] ?? '-' }}

                </small>

            </div>

            <hr>

            <p class="mb-2">

                🏛 <strong>Capital :</strong>

                {{ $country['capital'][0] ?? '-' }}

            </p>

            <p class="mb-2">

                🌍 <strong>Region :</strong>

                {{ $country['region'] ?? '-' }}

            </p>

            <p class="mb-2">

                💱 <strong>Currency :</strong>

                {{ array_key_first($country['currencies'] ?? []) }}

            </p>

            <p class="mb-4">

                🗣 <strong>Language :</strong>

                {{ implode(', ', array_values($country['languages'] ?? [])) }}

            </p>

            <a
                href="{{ route('dashboard',['country'=>$country['cca3']]) }}"
                class="btn btn-outline-info w-100">

                View Dashboard

            </a>

        </div>

    </div>

</div>

@endif

@empty

<div class="col-12">

    <div class="alert alert-warning">

        Country data not available.

    </div>

</div>

@endforelse

</div>

@endsection

@push('scripts')

<script>

document.addEventListener("DOMContentLoaded",function(){

    const search=document.getElementById("searchCountry");

    const cards=document.querySelectorAll(".country-card");

    search.addEventListener("keyup",function(){

        let keyword=this.value.toLowerCase();

        cards.forEach(function(card){

            let text=card.innerText.toLowerCase();

            card.style.display=text.includes(keyword) ? "" : "none";

        });

    });

});

</script>

@endpush