@extends('layouts.master')

@section('content')

<div class="container-fluid">

<h2 class="mb-4 fw-bold text-light">
    🌍 Country Comparison Engine
</h2>

<div class="card bg-dark border-secondary shadow mb-4">

    <div class="card-body">

        <form method="GET" class="row g-3">

            <div class="col-md-5">

                <label class="text-light mb-2">

                    Country 1

                </label>

                <select
                    name="country1"
                    class="form-select">

                    @foreach($countries as $code=>$name)

                        <option
                            value="{{ $code }}"
                            {{ $country1==$code ? 'selected' : '' }}>

                            {{ $name }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-5">

                <label class="text-light mb-2">

                    Country 2

                </label>

                <select
                    name="country2"
                    class="form-select">

                    @foreach($countries as $code=>$name)

                        <option
                            value="{{ $code }}"
                            {{ $country2==$code ? 'selected' : '' }}>

                            {{ $name }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-2 d-grid">

                <label class="text-light mb-2">&nbsp;</label>

                <button class="btn btn-primary">

                    Compare

                </button>

            </div>

        </form>

    </div>

</div>

<div class="card bg-dark border-secondary shadow">

<div class="card-header fw-bold text-info">

📊 Comparison Result

</div>

<div class="card-body">

<table class="table table-dark table-bordered align-middle">

<thead>

<tr>

<th width="35%">Indicator</th>

<th>{{ $countries[$country1] }}</th>

<th>{{ $countries[$country2] }}</th>

</tr>

</thead>

<tbody>

<tr>

<td>GDP</td>

<td>{{ $data1['gdp'] ? number_format($data1['gdp']) : '-' }}</td>

<td>{{ $data2['gdp'] ? number_format($data2['gdp']) : '-' }}</td>

</tr>

<tr>

<td>Inflation</td>

<td>{{ $data1['inflation'] ?? '-' }} %</td>

<td>{{ $data2['inflation'] ?? '-' }} %</td>

</tr>

<tr>

<td>Population</td>

<td>{{ number_format($data1['population']) }}</td>

<td>{{ number_format($data2['population']) }}</td>

</tr>

<tr>

<td>Temperature</td>

<td>{{ $data1['temperature'] }} °C</td>

<td>{{ $data2['temperature'] }} °C</td>

</tr>

<tr>

<td>Wind Speed</td>

<td>{{ $data1['wind'] }} km/h</td>

<td>{{ $data2['wind'] }} km/h</td>

</tr>

<tr>

<td>Rain</td>

<td>{{ $data1['rain'] }} mm</td>

<td>{{ $data2['rain'] }} mm</td>

</tr>

<tr>

<td>Currency</td>

<td>{{ $data1['currency'] }}</td>

<td>{{ $data2['currency'] }}</td>

</tr>

<tr>

<td>Exchange Rate (USD)</td>

<td>{{ $data1['exchange_rate'] }}</td>

<td>{{ $data2['exchange_rate'] }}</td>

</tr>

<tr>

<td>Risk Score</td>

<td>

<span class="badge bg-danger">

{{ $data1['risk_score'] }}

</span>

</td>

<td>

<span class="badge bg-danger">

{{ $data2['risk_score'] }}

</span>

</td>

</tr>

<tr>

<td>Risk Level</td>

<td>

<span class="badge bg-warning">

{{ $data1['risk_level'] }}

</span>

</td>

<td>

<span class="badge bg-warning">

{{ $data2['risk_level'] }}

</span>

</td>

</tr>

</tbody>

</table>

</div>

</div>

<div class="row mt-4">

    <div class="col-lg-12">

        <div class="card bg-dark border-secondary shadow">

            <div class="card-header fw-bold text-success">

                📈 Country Comparison Chart

            </div>

            <div class="card-body">

                <canvas id="comparisonChart" height="110"></canvas>

            </div>

        </div>

    </div>

</div>

</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener("DOMContentLoaded", function () {

    const ctx = document.getElementById("comparisonChart");

    if(!ctx) return;

    new Chart(ctx,{

        type:'bar',

        data:{

            labels:[

                'GDP',

                'Inflation',

                'Population',

                'Temperature',

                'Wind',

                'Rain',

                'Risk'

            ],

            datasets:[

                {

                    label:'{{ $countries[$country1] }}',

                    data:[

                        {{ ($data1['gdp'] ?? 0)/1000000000000 }},

                        {{ $data1['inflation'] ?? 0 }},

                        {{ ($data1['population'] ?? 0)/1000000 }},

                        {{ $data1['temperature'] ?? 0 }},

                        {{ $data1['wind'] ?? 0 }},

                        {{ $data1['rain'] ?? 0 }},

                        {{ $data1['risk_score'] ?? 0 }}

                    ]

                },

                {

                    label:'{{ $countries[$country2] }}',

                    data:[

                        {{ ($data2['gdp'] ?? 0)/1000000000000 }},

                        {{ $data2['inflation'] ?? 0 }},

                        {{ ($data2['population'] ?? 0)/1000000 }},

                        {{ $data2['temperature'] ?? 0 }},

                        {{ $data2['wind'] ?? 0 }},

                        {{ $data2['rain'] ?? 0 }},

                        {{ $data2['risk_score'] ?? 0 }}

                    ]

                }

            ]

        },

        options:{

            responsive:true,

            plugins:{

                legend:{

                    labels:{

                        color:'#ffffff'

                    }

                }

            },

            scales:{

                x:{

                    ticks:{

                        color:'#ffffff'

                    },

                    grid:{

                        color:'#444'

                    }

                },

                y:{

                    ticks:{

                        color:'#ffffff'

                    },

                    grid:{

                        color:'#444'

                    },

                    beginAtZero:true

                }

            }

        }

    });

});

</script>

@endpush