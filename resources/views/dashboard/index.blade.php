@extends('layouts.master')

@section('content')

<div class="container-fluid">

<h2 class="mb-4 fw-bold text-light">
    🌍 Global Supply Chain Risk Dashboard
</h2>

<div class="card bg-dark border-secondary shadow mb-4">

    <div class="card-body">

        <form method="GET" action="{{ route('dashboard') }}">

            <label class="text-light fw-semibold mb-2">

                🌍 Select Country

            </label>

            <select
                name="country"
                class="form-select"
                onchange="this.form.submit()">

                @foreach($countries as $country)

                    <option
                        value="{{ $country['cca3'] }}"
                        {{ $selectedCountry == $country['cca3'] ? 'selected' : '' }}>

                        {{ $country['flag'] ?? '🏳️' }}
                        {{ $country['name']['common'] }}

                    </option>

                @endforeach

            </select>

        </form>

    </div>

</div>

<div class="row g-4">

<div class="col-lg-8">

<div class="card bg-dark border-secondary shadow h-100">

<div class="card-header fw-bold text-info">

🌍 Country Overview

</div>

<div class="card-body">

<div class="row">

<div class="col-md-6 mb-3">

<small class="text-secondary">

Country

</small>

<h4 class="text-light">

{{ $countryData['flag'] ?? '' }}

{{ $countryName }}

</h4>

</div>

<div class="col-md-6 mb-3">

<small class="text-secondary">

Capital

</small>

<h5 class="text-light">

{{ $capital }}

</h5>

</div>

<div class="col-md-6 mb-3">

<small class="text-secondary">

Region

</small>

<h5 class="text-light">

{{ $region }}

</h5>

</div>

<div class="col-md-6 mb-3">

<small class="text-secondary">

Population

</small>

<h5 class="text-light">

{{ number_format($population) }}

</h5>

</div>

<div class="col-md-6 mb-3">

<small class="text-secondary">

GDP

</small>

<h5 class="text-warning">

{{ $economy['gdp'] ? number_format($economy['gdp']) : '-' }}

</h5>

</div>

<div class="col-md-6 mb-3">

<small class="text-secondary">

Inflation

</small>

<h5 class="text-warning">

{{ $economy['inflation'] ?? '-' }} %

</h5>

</div>

<div class="col-md-6 mb-3">

<small class="text-secondary">

Currency

</small>

<h5 class="text-info">

{{ $currencyCode }}

</h5>

</div>

<div class="col-md-6 mb-3">

<small class="text-secondary">

Exchange Rate

</small>

<h5 class="text-info">

{{ $exchangeRate ?? '-' }}

</h5>

</div>

<div class="col-md-4">

<small class="text-secondary">

🌡 Temperature

</small>

<h5 class="text-success">

{{ $temperature }} °C

</h5>

</div>

<div class="col-md-4">

<small class="text-secondary">

💨 Wind

</small>

<h5 class="text-success">

{{ $windSpeed }} km/h

</h5>

</div>

<div class="col-md-4">

<small class="text-secondary">

🌧 Rain

</small>

<h5 class="text-success">

{{ $rain }} mm

</h5>

</div>

</div>

</div>

</div>

</div>

<div class="col-lg-4">

<div class="card bg-dark border-secondary shadow h-100">

<div class="card-header fw-bold text-danger">

⚠ Overall Risk

</div>

<div class="card-body text-center">

<h1 class="display-3 fw-bold text-{{ $badge }}">

{{ $riskScore }}

</h1>

<span class="badge bg-{{ $badge }} fs-6">

{{ $riskLevel }}

</span>

<hr class="border-secondary">

<p class="text-light">

{{ $recommendation }}

</p>

</div>

</div>

</div>

</div>

<div class="row mt-4">

<div class="col-lg-12">

<div class="card bg-dark border-secondary shadow">

<div class="card-header fw-bold text-warning">

📊 Risk Breakdown

</div>

<div class="card-body">

<div class="row text-center">

<div class="col">

<h6 class="text-info">

Weather

</h6>

<h3>

{{ $weatherRisk }}

</h3>

</div>

<div class="col">

<h6 class="text-info">

Economy

</h6>

<h3>

{{ $economyRisk }}

</h3>

</div>

<div class="col">

<h6 class="text-info">

Currency

</h6>

<h3>

{{ $currencyRisk }}

</h3>

</div>

<div class="col">

<h6 class="text-info">

News

</h6>

<h3>

{{ $newsRisk }}

</h3>

</div>

<div class="col">

<h6 class="text-info">

Port

</h6>

<h3>

{{ $portRisk }}

</h3>

</div>

</div>

</div>

</div>

</div>

</div>

<div class="row mt-4">

    {{-- CHART --}}
    <div class="col-lg-8">

        <div class="card bg-dark border-secondary shadow h-100">

            <div class="card-header fw-bold text-info">

                📈 Supply Chain Risk Analytics

            </div>

            <div class="card-body">

                <canvas id="riskChart" height="120"></canvas>

            </div>

        </div>

    </div>

    {{-- NEWS --}}
    <div class="col-lg-4">

        <div class="card bg-dark border-secondary shadow h-100">

            <div class="card-header fw-bold text-warning">

                📰 Latest News

            </div>

            <div class="card-body">

                @forelse($news as $article)

                    <div class="mb-3 pb-3 border-bottom border-secondary">

                        <h6 class="text-info">

                            {{ $article['title'] }}

                        </h6>

                        <small class="text-secondary">

                            {{ \Illuminate\Support\Str::limit($article['description'],120) }}

                        </small>

                        <br>

                        <a
                            href="{{ $article['url'] }}"
                            target="_blank"
                            class="btn btn-sm btn-outline-info mt-2">

                            Read More

                        </a>

                    </div>

                @empty

                    <div class="alert alert-warning mb-0">

                        No news available.

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>

<div class="row mt-4">

    <div class="col-lg-12">

        <div class="card bg-dark border-secondary shadow">

            <div class="card-header fw-bold text-success">

                🌍 World Monitoring Map

            </div>

            <div class="card-body p-0">

                <div
                    id="map"
                    style="height:550px;">

                </div>

            </div>

        </div>

    </div>

</div>

</div>

@endsection

@push('scripts')

<link
rel="stylesheet"
href="https://unpkg.com/leaflet/dist/leaflet.css"/>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener("DOMContentLoaded", function () {

    /*
    =====================================
    CHART.JS
    =====================================
    */

    const ctx = document.getElementById('riskChart').getContext('2d');

    new Chart(ctx, {

        type: 'bar',

        data: {

            labels: @json($riskChart['labels']),

            datasets: [{

                label: 'Risk Score',

                data: @json($riskChart['data']),

                borderWidth: 1

            }]

        },

        options: {

            responsive: true,

            plugins: {

                legend: {

                    labels: {

                        color: '#ffffff'

                    }

                }

            },

            scales: {

                x: {

                    ticks: {

                        color: '#ffffff'

                    },

                    grid: {

                        color: '#444'

                    }

                },

                y: {

                    beginAtZero: true,

                    max: 100,

                    ticks: {

                        color: '#ffffff'

                    },

                    grid: {

                        color: '#444'

                    }

                }

            }

        }

    });

    /*
    =====================================
    LEAFLET
    =====================================
    */

    var map = L.map('map').setView([

        {{ $latitude }},

        {{ $longitude }}

    ],5);

    L.tileLayer(

        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',

        {

            attribution: '&copy; OpenStreetMap'

        }

    ).addTo(map);

    L.marker([

        {{ $latitude }},

        {{ $longitude }}

    ])

    .addTo(map)

    .bindPopup(`

        <b>{{ $countryName }}</b><br>

        🌡 Temperature :
        {{ $temperature }} °C<br>

        💨 Wind :
        {{ $windSpeed }} km/h<br>

        🌧 Rain :
        {{ $rain }} mm<br>

        ⚠ Risk :
        {{ $riskScore }} ({{ $riskLevel }})

    `)

    .openPopup();

});

</script>

@endpush