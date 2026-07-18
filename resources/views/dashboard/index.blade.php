@extends('layouts.master')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold text-white mb-1">
                Global Supply Chain Risk Dashboard
            </h2>

            <p class="text-secondary mb-0">
                Real-time monitoring of global supply chain conditions.
            </p>

        </div>

        <div class="text-end">

            <span class="badge bg-success px-3 py-2">
                ● Live Monitoring
            </span>

        </div>

    </div>

    {{-- TOP CARD --}}
    <div class="row g-4 mb-4">

        {{-- COUNTRY MONITORING --}}
        <div class="col-lg-8">

            <div class="card shadow-lg h-100">

                <div class="card-header d-flex justify-content-between align-items-center">

                    <h5 class="mb-0 fw-bold">
                        🌍 Country Monitoring
                    </h5>

                    <span class="badge bg-primary">
                        Live
                    </span>

                </div>

                <div class="card-body">

                    <form method="GET"
                          action="{{ route('dashboard') }}">

                        <label class="form-label fw-semibold mb-2">

                            Select Country

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

                    <form
                        action="{{ route('watchlists.store') }}"
                        method="POST"
                        class="mt-3">

                        @csrf

                        <input
                            type="hidden"
                            name="country_code"
                            value="{{ $selectedCountry }}">

                        <input
                            type="hidden"
                            name="country_name"
                            value="{{ $countryName }}">

                        <button class="btn btn-primary">

                            ⭐ Add To Favorite

                        </button>

                    </form>

                </div>

            </div>

        </div>

        {{-- OVERALL RISK --}}
        <div class="col-lg-4">

            <div class="card shadow-lg h-100">

                <div class="card-header">

                    <h5 class="mb-0 fw-bold">

                        ⚠ Overall Risk

                    </h5>

                </div>

                <div class="card-body text-center">

                    <h1 class="display-2 fw-bold text-{{ $badge }}">

                        {{ $riskScore }}

                    </h1>

                    <span class="badge bg-{{ $badge }} fs-6 px-3 py-2">

                        {{ $riskLevel }}

                    </span>

                    <hr>

                    <p class="text-secondary">

                        {{ $recommendation }}

                    </p>

                </div>

            </div>

        </div>

    </div>
        {{-- RISK BREAKDOWN --}}
    <div class="row g-4 mb-4">

        <div class="col-12">

            <div class="card shadow-lg">

                <div class="card-header">

                    <h5 class="mb-0 fw-bold">

                        📊 Risk Breakdown

                    </h5>

                </div>

                <div class="card-body">

                    <div class="row text-center">

                        <div class="col-md">

                            <div class="p-3 rounded">

                                <h6 class="text-secondary mb-2">

                                    🌦 Weather

                                </h6>

                                <h2 class="fw-bold">

                                    {{ $weatherRisk }}

                                </h2>

                            </div>

                        </div>

                        <div class="col-md">

                            <div class="p-3 rounded">

                                <h6 class="text-secondary mb-2">

                                    📈 Economy

                                </h6>

                                <h2 class="fw-bold">

                                    {{ $economyRisk }}

                                </h2>

                            </div>

                        </div>

                        <div class="col-md">

                            <div class="p-3 rounded">

                                <h6 class="text-secondary mb-2">

                                    💱 Currency

                                </h6>

                                <h2 class="fw-bold">

                                    {{ $currencyRisk }}

                                </h2>

                            </div>

                        </div>

                        <div class="col-md">

                            <div class="p-3 rounded">

                                <h6 class="text-secondary mb-2">

                                    📰 News

                                </h6>

                                <h2 class="fw-bold">

                                    {{ $newsRisk }}

                                </h2>

                            </div>

                        </div>

                        <div class="col-md">

                            <div class="p-3 rounded">

                                <h6 class="text-secondary mb-2">

                                    🚢 Port

                                </h6>

                                <h2 class="fw-bold">

                                    {{ $portRisk }}

                                </h2>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- COUNTRY OVERVIEW --}}
    <div class="row g-4 mb-4">

        <div class="col-12">

            <div class="card shadow-lg">

                <div class="card-header">

                    <h5 class="mb-0 fw-bold">

                        🌍 Country Overview

                    </h5>

                </div>

                <div class="card-body">

                    <div class="row g-4">

                        <div class="col-md-3">

                            <small class="text-secondary">

                                Country

                            </small>

                            <h5 class="mt-2">

                                {{ $countryData['flag'] ?? '' }}
                                {{ $countryName }}

                            </h5>

                        </div>

                        <div class="col-md-3">

                            <small class="text-secondary">

                                Capital

                            </small>

                            <h5 class="mt-2">

                                {{ $capital }}

                            </h5>

                        </div>

                        <div class="col-md-3">

                            <small class="text-secondary">

                                Region

                            </small>

                            <h5 class="mt-2">

                                {{ $region }}

                            </h5>

                        </div>

                        <div class="col-md-3">

                            <small class="text-secondary">

                                Population

                            </small>

                            <h5 class="mt-2">

                                {{ number_format($population) }}

                            </h5>

                        </div>

                        <div class="col-md-3">

                            <small class="text-secondary">

                                GDP

                            </small>

                            <h5 class="mt-2 text-warning">

                                {{ $economy->gdp ? number_format($economy->gdp) : '-' }}

                            </h5>

                        </div>

                        <div class="col-md-3">

                            <small class="text-secondary">

                                Inflation

                            </small>

                            <h5 class="mt-2 text-warning">

                                {{ $economy['inflation'] ?? '-' }} %

                            </h5>

                        </div>

                        <div class="col-md-3">

                            <small class="text-secondary">

                                Currency

                            </small>

                            <h5 class="mt-2 text-info">

                                {{ $currencyCode }}

                            </h5>

                        </div>

                        <div class="col-md-3">

                            <small class="text-secondary">

                                Exchange Rate

                            </small>

                            <h5 class="mt-2 text-info">

                                {{ $exchangeRate ?? '-' }}

                            </h5>

                        </div>

                        <div class="col-md-4">

                            <small class="text-secondary">

                                🌡 Temperature

                            </small>

                            <h5 class="mt-2 text-success">

                                {{ $temperature }} °C

                            </h5>

                        </div>

                        <div class="col-md-4">

                            <small class="text-secondary">

                                💨 Wind

                            </small>

                            <h5 class="mt-2 text-success">

                                {{ $windSpeed }} km/h

                            </h5>

                        </div>

                        <div class="col-md-4">

                            <small class="text-secondary">

                                🌧 Rain

                            </small>

                            <h5 class="mt-2 text-success">

                                {{ $rain }} mm

                            </h5>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
        {{-- ANALYTICS & NEWS --}}
    <div class="row g-4 mb-4">

        {{-- ANALYTICS --}}
        <div class="col-lg-8">

            <div class="card shadow-lg h-100">

                <div class="card-header d-flex justify-content-between align-items-center">

                    <h5 class="mb-0 fw-bold">
                        📈 Supply Chain Risk Analytics
                    </h5>

                    <span class="badge bg-info">
                        Live Chart
                    </span>

                </div>

                <div class="card-body">

                    <canvas id="riskChart" height="110"></canvas>

                </div>

            </div>

        </div>

        {{-- NEWS --}}
        <div class="col-lg-4">

            <div class="card shadow-lg h-100">

                <div class="card-header d-flex justify-content-between align-items-center">

                    <h5 class="mb-0 fw-bold">
                        📰 Latest News
                    </h5>

                    <span class="badge bg-warning text-dark">
                        Updated
                    </span>

                </div>

                <div class="card-body">

                    @forelse($news as $article)

                        <div class="pb-3 mb-3 border-bottom">

                            <h6 class="fw-bold">

                                {{ $article['title'] }}

                            </h6>

                            <small class="text-secondary d-block mb-2">

                                {{ \Illuminate\Support\Str::limit($article['description'],100) }}

                            </small>

                            <a
                                href="{{ $article['url'] }}"
                                target="_blank"
                                class="btn btn-sm btn-outline-primary">

                                Read More →

                            </a>

                        </div>

                    @empty

                        <div class="alert alert-warning mb-0">

                            No latest news available.

                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>
        {{-- WORLD MONITORING MAP --}}
    <div class="row">

        <div class="col-12">

            <div class="card shadow-lg">

                <div class="card-header d-flex justify-content-between align-items-center">

                    <h5 class="mb-0 fw-bold">

                        🌍 World Monitoring Map

                    </h5>

                    <span class="badge bg-success">

                        Live Location

                    </span>

                </div>

                <div class="card-body p-0">

                    <div
                        id="map"
                        style="height:600px;border-radius:0 0 16px 16px;overflow:hidden;">

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

                borderRadius: 10,

                borderWidth: 0,

                backgroundColor: [
                    '#3B82F6',
                    '#10B981',
                    '#F59E0B',
                    '#EF4444',
                    '#8B5CF6'
                ]

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,
                        plugins: {

                legend: {

                    labels: {

                        color: "#ffffff"

                    }

                }

            },

            scales: {

                x: {

                    ticks: {

                        color: "#ffffff"

                    },

                    grid: {

                        color: "rgba(255,255,255,.08)"

                    }

                },

                y: {

                    beginAtZero: true,

                    max: 100,

                    ticks: {

                        color: "#ffffff"

                    },

                    grid: {

                        color: "rgba(255,255,255,.08)"

                    }

                }

            }

        }

    });

    /*
    =====================================
    LEAFLET MAP
    =====================================
    */

    const map = L.map('map').setView([

        {{ $latitude }},

        {{ $longitude }}

    ], 5);

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

    .bindPopup(

        `<b>{{ $countryName }}</b><br>

        🌡 Temperature : {{ $temperature }} °C<br>

        💨 Wind : {{ $windSpeed }} km/h<br>

        🌧 Rain : {{ $rain }} mm<br>

        ⚠ Risk : {{ $riskScore }} ({{ $riskLevel }})`

    )

    .openPopup();

});

</script>

@endpush