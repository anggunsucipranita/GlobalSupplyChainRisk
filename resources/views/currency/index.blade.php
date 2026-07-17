@extends('layouts.master')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="fw-bold text-light">

        💱 Currency Dashboard

    </h2>

    <button
        id="refreshCurrency"
        class="btn btn-primary">

        🔄 Refresh Currency

    </button>

</div>

@if(isset($currency['rates']))

<div class="row g-3">

    <div class="col-md-3">

        <div class="card bg-dark text-light border-secondary p-3">

            <h6>USD → IDR</h6>

            <h3
                id="idrRate"
                class="text-warning">

                {{ number_format($currency['rates']['IDR'],2) }}

            </h3>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card bg-dark text-light border-secondary p-3">

            <h6>USD → EUR</h6>

            <h3
                id="eurRate"
                class="text-info">

                {{ $currency['rates']['EUR'] }}

            </h3>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card bg-dark text-light border-secondary p-3">

            <h6>USD → JPY</h6>

            <h3
                id="jpyRate"
                class="text-success">

                {{ $currency['rates']['JPY'] }}

            </h3>

        </div>

    </div>

</div>

<div class="card bg-dark border-secondary mt-4">

    <div class="card-header">

        <h5 class="text-info mb-0">

            📈 Currency Trend Chart

        </h5>

    </div>

    <div class="card-body">

        <canvas id="currencyChart" height="100"></canvas>

    </div>

</div>

@else

<div class="alert alert-warning">

    Data kurs tidak tersedia.

</div>

@endif

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('currencyChart');

if (ctx) {

    new Chart(ctx, {

        type: 'line',

        data: {

            labels: @json($chartLabels),

            datasets: [{

                label: 'Exchange Rate',

                data: @json($chartRates),

                borderColor: '#0dcaf0',

                backgroundColor: 'rgba(13,202,240,.2)',

                fill: true,

                borderWidth: 3,

                tension: .4

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

                    ticks: {

                        color: 'white'

                    },

                    grid: {

                        color: 'rgba(255,255,255,.1)'

                    }

                },

                y: {

                    ticks: {

                        color: 'white'

                    },

                    grid: {

                        color: 'rgba(255,255,255,.1)'

                    }

                }

            }

        }

    });

}

</script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>

document.getElementById('refreshCurrency').addEventListener('click', function () {

    axios.get('/api/currency')

        .then(function (response) {

            const rates = response.data.rates;

            document.getElementById('idrRate').innerHTML =
                Number(rates.IDR).toLocaleString('id-ID', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });

            document.getElementById('eurRate').innerHTML = rates.EUR;

            document.getElementById('jpyRate').innerHTML = rates.JPY;

            alert('✅ Exchange rate berhasil diperbarui!');

        })

        .catch(function (error) {

            alert('❌ Gagal mengambil data terbaru.');

            console.log(error);

        });

});

</script>

@endsection