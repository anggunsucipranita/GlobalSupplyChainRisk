@extends('layouts.master')

@section('content')

<h2 class="mb-4 fw-bold text-light">
    🌍 Global Supply Chain Risk Dashboard
</h2>

{{-- CARDS --}}
<div class="row g-3">

    <div class="col-md-3">
        <div class="card bg-dark text-light border-secondary p-3">
            <h6>🌍 Total Countries</h6>
            <h2 class="fw-bold text-info">
                {{ $totalCountries ?? 0 }}
            </h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-dark text-light border-secondary p-3">
            <h6>🌦 Weather</h6>
            <h2 class="fw-bold text-success">28°C</h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-dark text-light border-secondary p-3">
            <h6>💱 Currency</h6>
            <h2 class="fw-bold text-warning">USD/IDR</h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-dark text-light border-secondary p-3">
            <h6>⚠ Risk Score</h6>
            <h2 class="fw-bold text-danger">Medium</h2>
        </div>
    </div>

</div>

{{-- CHART + NEWS --}}
<div class="row mt-4">

    {{-- CHART --}}
    <div class="col-lg-8 mb-4">
        <div class="card bg-dark text-light border-secondary">
            <div class="card-header fw-bold">
                📈 Supply Chain Risk Trend
            </div>
            <div class="card-body">
                <canvas id="riskChart" height="120"></canvas>
            </div>
        </div>
    </div>

    {{-- NEWS --}}
    <div class="col-lg-4 mb-4">
        <div class="card bg-dark text-light border-secondary">
            <div class="card-header fw-bold">
                📰 Latest News
            </div>

            <div class="card-body">
                <ul class="list-group list-group-flush">

                    <li class="list-group-item bg-dark text-light border-secondary">
                        Global shipping increases due to Red Sea tensions
                    </li>

                    <li class="list-group-item bg-dark text-light border-secondary">
                        Inflation concerns rise in Europe
                    </li>

                    <li class="list-group-item bg-dark text-light border-secondary">
                        Trade agreement progress US-EU
                    </li>

                </ul>
            </div>
        </div>
    </div>

</div>

{{-- MAP --}}
<div class="card bg-dark text-light border-secondary mt-3">

    <div class="card-header fw-bold">
        🌍 World Map (Leaflet)
    </div>

    <div class="card-body">

        <div id="map"
            style="height:500px;
            background:#0f172a;
            border-radius:10px;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#94a3b8;">

            Leaflet Map Will Be Here

        </div>

    </div>

</div>

@endsection


{{-- SCRIPT --}}
@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const canvas = document.getElementById('riskChart');

    if (!canvas) return; // 🔥 safety biar gak error kalau DOM belum ready

    const ctx = canvas.getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Risk Level',
                data: [30, 45, 40, 60, 55, 70, 65],
                borderColor: '#38bdf8',
                backgroundColor: 'rgba(56,189,248,0.2)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: {
                        color: 'white'
                    }
                }
            },
            scales: {
                x: {
                    ticks: { color: 'white' }
                },
                y: {
                    ticks: { color: 'white' }
                }
            }
        }
    });

});
</script>

@endpush