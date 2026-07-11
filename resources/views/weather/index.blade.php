@extends('layouts.master')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
@endpush

@section('content')

<h2 class="mb-4 fw-bold text-light">
    🌦 Global Weather Monitoring
</h2>

<form method="GET" class="mb-4">

    <label class="form-label text-light">
        🌍 Select Country
    </label>

    <select
        name="country"
        class="form-select"
        onchange="this.form.submit()">

        @foreach($countries as $country)

            <option
                value="{{ $country['cca3'] }}"
                {{ $selected == $country['cca3'] ? 'selected' : '' }}>

                {{ $country['flag'] ?? '🏳️' }}
                {{ $country['name']['common'] }}

            </option>

        @endforeach

    </select>

</form>

<div class="row g-3 mb-4">

    <div class="col-md-4">

        <div class="card bg-dark border-secondary h-100 shadow">

            <div class="card-body text-center">

                <h5 class="text-light">
                    🌡 Temperature
                </h5>

                <h2 class="text-info">

                    {{ $weather['current']['temperature_2m'] ?? '-' }} °C

                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card bg-dark border-secondary h-100 shadow">

            <div class="card-body text-center">

                <h5 class="text-light">
                    💨 Wind Speed
                </h5>

                <h2 class="text-warning">

                    {{ $weather['current']['wind_speed_10m'] ?? '-' }} km/h

                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card bg-dark border-secondary h-100 shadow">

            <div class="card-body text-center">

                <h5 class="text-light">
                    🌧 Rain
                </h5>

                <h2 class="text-success">

                    {{ $weather['current']['rain'] ?? 0 }} mm

                </h2>

            </div>

        </div>

    </div>

</div>

<div class="card bg-dark border-secondary shadow">

    <div class="card-body">

        <h5 class="text-light mb-3">

            📍 Location :
            {{ $weather['city'] ?? '-' }}

        </h5>

        <div
            id="map"
            style="
                width:100%;
                height:500px;
                border-radius:12px;
                overflow:hidden;
            ">
        </div>

    </div>

</div>

@endsection

@push('scripts')

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

@if(!empty($weather))

<script>

document.addEventListener("DOMContentLoaded", function () {

    const map = L.map("map").setView(
        [
            {{ $weather['latitude'] }},
            {{ $weather['longitude'] }}
        ],
        5
    );

    L.tileLayer(
        "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
        {
            maxZoom: 18,
            attribution: "&copy; OpenStreetMap"
        }
    ).addTo(map);

    L.marker(
        [
            {{ $weather['latitude'] }},
            {{ $weather['longitude'] }}
        ]
    )
    .addTo(map)
    .bindPopup("<b>{{ $weather['city'] }}</b>")
    .openPopup();

    setTimeout(function () {
        map.invalidateSize();
    }, 300);

});

</script>

@endif

@endpush