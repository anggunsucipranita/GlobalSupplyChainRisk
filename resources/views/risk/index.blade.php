@extends('layouts.master')

@section('content')

<h2 class="mb-4 fw-bold text-light">
    ⚠️ Supply Chain Risk Analysis
</h2>

<form method="GET" class="mb-4">

    <select
        name="country"
        class="form-select"
        onchange="this.form.submit()">

        @foreach($countries as $item)

            <option
                value="{{ $item['cca3'] }}"
                {{ $country == $item['cca3'] ? 'selected' : '' }}>

                {{ $item['flag'] ?? '🏳️' }}
                {{ $item['name']['common'] }}

            </option>

        @endforeach

    </select>

</form>

<div class="row g-3">

    <div class="col-md-8">

        <div class="card bg-dark border-secondary shadow">

            <div class="card-body">

<h4 class="text-info mb-4">
    🌍 {{ $countryName }}
</h4>

<div class="row g-3 mb-4">

    <div class="col-lg-2 col-md-4 col-6">

        <div class="card bg-dark border border-secondary shadow-sm rounded-4 h-100">

            <div class="card-body text-center py-4">

                <small class="text-light">📈 Inflation</small>

                <h5 class="text-warning mt-2">

                    {{ $inflation !== null ? number_format($inflation,2).'%' : '-' }}

                </h5>

            </div>

        </div>

    </div>

    <div class="col-lg-2 col-md-4 col-6">

        <div class="card bg-dark border border-secondary shadow-sm rounded-4 h-100">

            <div class="card-body text-center py-4">

                <small class="text-light">💱 Currency</small>

                <h5 class="text-info mt-2">

                    {{ $currencyCode ?? '-' }}

                </h5>

            </div>

        </div>

    </div>

    <div class="col-lg-2 col-md-4 col-6">

        <div class="card bg-dark border border-secondary shadow-sm rounded-4 h-100">

            <div class="card-body text-center py-4">

                <small class="text-light">💲 Rate</small>

                <h5 class="text-success mt-2">

                    {{ isset($rate) ? number_format($rate,2) : '-' }}

                </h5>

            </div>

        </div>

    </div>

    <div class="col-lg-2 col-md-4 col-6">

        <div class="card bg-dark border border-secondary shadow-sm rounded-4 h-100">

            <div class="card-body text-center py-4">

                <small class="text-light">📰 News</small>

                <h5 class="text-danger mt-2">

                    {{ $newsCount }}

                </h5>

            </div>

        </div>

    </div>

<div class="col-lg-2 col-md-4 col-6">

        <div class="card bg-dark border border-secondary shadow-sm rounded-4 h-100">

            <div class="card-body text-center py-4">

                <small class="text-light">🚢 Ports</small>

                <h5 class="text-primary mt-2">

                    {{ $totalPorts }}

                </h5>

            </div>

        </div>

    </div>

    <div class="col-lg-2 col-md-4 col-6">

        <div class="card bg-dark border border-secondary shadow-sm rounded-4 h-100">
            
        <div class="card-body text-center py-4">

                <small class="text-light">🌧 Rain</small>

                <h5 class="text-info mt-2">

                    {{ $rain }} mm

                </h5>

            </div>

        </div>

    </div>

</div>

<hr>
                </p>

                <div class="mb-3">

                    <label class="text-light">
                        🌦 Weather Risk
                    </label>

                    <div class="progress">

                        <div
                            class="progress-bar {{ $risk['weather'] <= 30 ? 'bg-success' : ($risk['weather'] <= 60 ? 'bg-warning' : 'bg-danger') }}"
                            style="width: {{ $risk['weather'] }}%">

                            {{ $risk['weather'] }}%

                        </div>

                    </div>

                </div>

                <div class="mb-3">

                    <label class="text-light">
                        📈 Economy Risk
                    </label>

                    <div class="progress">

                        <div
                            class="progress-bar {{ $risk['economy'] <= 30 ? 'bg-success' : ($risk['economy'] <= 60 ? 'bg-warning' : 'bg-danger') }}"
                            style="width: {{ $risk['economy'] }}%">

                            {{ $risk['economy'] }}%

                        </div>

                    </div>

                </div>

                <div class="mb-3">

                    <label class="text-light">
                        💱 Currency Risk
                    </label>

                    <div class="progress">

                        <div
                            class="progress-bar {{ $risk['currency'] <= 30 ? 'bg-success' : ($risk['currency'] <= 60 ? 'bg-warning' : 'bg-danger') }}"
                            style="width: {{ $risk['currency'] }}%">

                            {{ $risk['currency'] }}%

                        </div>

                    </div>

                </div>

                <div class="mb-3">

                    <label class="text-light">
                        📰 News Risk
                    </label>

                    <div class="progress">

                        <div
                            class="progress-bar {{ $risk['news'] <= 30 ? 'bg-success' : ($risk['news'] <= 60 ? 'bg-warning' : 'bg-danger') }}"
                            style="width: {{ $risk['news'] }}%">

                            {{ $risk['news'] }}%

                        </div>

                    </div>

                </div>

                <div>

                    <label class="text-light">
                        🚢 Port Risk
                    </label>

                    <div class="progress">

                        <div
                            class="progress-bar {{ $risk['port'] <= 30 ? 'bg-success' : ($risk['port'] <= 60 ? 'bg-warning' : 'bg-danger') }}"
                            style="width: {{ $risk['port'] }}%">

                            {{ $risk['port'] }}%

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card bg-dark border-secondary shadow h-100">

            <div class="card-body text-center">

                <h5 class="text-light">
                    Overall Risk
                </h5>

                <h1 class="display-3 text-{{ $color }}">
                    {{ $score }}
                </h1>

                <div class="my-3">

    <canvas id="overallChart" height="180"></canvas>

</div>

                <span class="badge bg-{{ $color }} fs-5">

                    {{ $level }}

                </span>
                @if($level == 'LOW')

    <p class="mt-3 text-success fw-bold">

        🟢 Safe

    </p>

@endif

@if($level == 'MEDIUM')

    <p class="mt-3 text-warning fw-bold">

        🟡 Warning

    </p>

@endif

@if($level == 'HIGH')

    <p class="mt-3 text-danger fw-bold">

        🔴 Critical

    </p>

@endif

                <hr class="text-secondary">

<p class="text-secondary">

    Supply Chain Risk Score

</p>

<p class="text-secondary mt-3">

    Last Update<br>

    <strong>{{ $updatedAt }}</strong>

</p>

            </div>

        </div>

    </div>

</div>

<div class="row mt-4">

    <div class="col-12">

        <div class="card bg-dark border-secondary shadow">

            <div class="card-body">

                <h5 class="text-light mb-3">
                    📊 Risk Comparison
                </h5>

                <canvas id="riskChart" height="90"></canvas>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

const ctx = document.getElementById('riskChart');

new Chart(ctx, {

    type: 'bar',

    data: {

        labels: [
            'Weather',
            'Economy',
            'Currency',
            'News',
            'Port'
        ],

        datasets: [{

            label: 'Risk Score',

            data: [

                {{ $risk['weather'] }},
                {{ $risk['economy'] }},
                {{ $risk['currency'] }},
                {{ $risk['news'] }},
                {{ $risk['port'] }}

            ]

        }]

    },

    options: {

        responsive: true,

        scales: {

            y: {

                beginAtZero: true,

                max: 100

            }

        }

    }

});

const overallCtx = document.getElementById('overallChart');

new Chart(overallCtx, {

    type: 'doughnut',

    data: {

        labels: ['Risk', 'Safe'],

        datasets: [{

            data: [

                {{ $score }},
                {{ 100 - $score }}

            ],

            backgroundColor: [

                '#dc3545',
                '#198754'

            ],

            borderWidth: 0

        }]

    },

    options: {

        plugins: {

            legend: {

                labels: {

                    color: 'white'

                }

            }

        }

    }

});

</script>

@endpush

