@extends('layouts.master')

@section('content')

<h2 class="mb-4 fw-bold text-light">
    📊 Country Comparison
</h2>

<form method="GET" class="row g-3 mb-4">

    <div class="col-md-5">

        <label class="form-label text-light">
            Country 1
        </label>

        <select name="country1" class="form-select">

            @foreach($countries as $code => $name)

                <option value="{{ $code }}"
                    {{ $country1 == $code ? 'selected' : '' }}>

                    {{ $name }}

                </option>

            @endforeach

        </select>

    </div>

    <div class="col-md-5">

        <label class="form-label text-light">
            Country 2
        </label>

        <select name="country2" class="form-select">

            @foreach($countries as $code => $name)

                <option value="{{ $code }}"
                    {{ $country2 == $code ? 'selected' : '' }}>

                    {{ $name }}

                </option>

            @endforeach

        </select>

    </div>

    <div class="col-md-2 d-grid">

        <label class="form-label text-light">&nbsp;</label>

        <button class="btn btn-primary">

            Compare

        </button>

    </div>

</form>

<div class="card bg-dark border-secondary">

    <div class="card-body">

        <table class="table table-dark table-bordered align-middle">

            <thead>

                <tr>

                    <th>Indicator</th>

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

                    <td>{{ $data1['inflation'] ?? '-' }}</td>

                    <td>{{ $data2['inflation'] ?? '-' }}</td>

                </tr>

                <tr>

                    <td>Population</td>

                    <td>{{ $data1['population'] ? number_format($data1['population']) : '-' }}</td>

                    <td>{{ $data2['population'] ? number_format($data2['population']) : '-' }}</td>

                </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection