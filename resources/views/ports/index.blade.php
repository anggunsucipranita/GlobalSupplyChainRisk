@extends('layouts.master')

@section('content')

<h2 class="mb-4 fw-bold text-light">
    🚢 Port Dashboard
</h2>

<div class="input-group mb-4">

    <input
        type="text"
        id="searchPort"
        class="form-control"
        placeholder="Search port or country...">

</div>

<div class="row g-3">

@forelse($ports as $port)

<div class="col-lg-4 col-md-6 port-card">

    <div class="card bg-dark text-light border-secondary shadow h-100">

        <div class="card-body">

            <h5 class="text-info">

                🚢 {{ $port['name'] }}

            </h5>

            <hr>

            <p class="mb-2">

                🌍 <strong>Country :</strong>

                {{ $port['country'] }}

            </p>

            <p class="mb-2">

                📍 <strong>Latitude :</strong>

                {{ $port['lat'] }}

            </p>

            <p class="mb-2">

                📍 <strong>Longitude :</strong>

                {{ $port['lng'] }}

            </p>

            <p class="mb-0">

                ⚓ <strong>Port Size :</strong>

                <span class="badge bg-primary">

                    {{ ucfirst($port['size']) }}

                </span>

            </p>

        </div>

    </div>

</div>

@empty

<div class="col-12">

    <div class="alert alert-warning">

        Data pelabuhan tidak ditemukan.

    </div>

</div>

@endforelse

</div>

@endsection

@push('scripts')

<script>

document.addEventListener("DOMContentLoaded", function () {

    const search = document.getElementById("searchPort");

    const cards = document.querySelectorAll(".port-card");

    search.addEventListener("keyup", function () {

        const keyword = this.value.toLowerCase();

        cards.forEach(function(card){

            const text = card.innerText.toLowerCase();

            card.style.display = text.includes(keyword) ? "" : "none";

        });

    });

});

</script>

@endpush