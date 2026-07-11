@extends('layouts.master')

@section('content')

<h2 class="mb-4 fw-bold text-light">
    📊 Economy Dashboard
</h2>

<h4 class="text-info mb-3">
    Selected Country : {{ $country }}
</h4>

<form method="GET" class="mb-4">

    <select name="country" class="form-select" onchange="this.form.submit()">

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

    <div class="col-md-4">
        <div class="card bg-dark text-light border-secondary p-3 h-100">
            <h6>GDP</h6>
            <h4 class="text-success">
                {{ $economy['gdp'] ? number_format($economy['gdp']) : '-' }}
            </h4>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-dark text-light border-secondary p-3 h-100">
            <h6>Inflation</h6>
            <h4 class="text-warning">
                {{ $economy['inflation'] ?? '-' }}
            </h4>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-dark text-light border-secondary p-3 h-100">
            <h6>Population</h6>
            <h4 class="text-info">
                {{ $economy['population'] ? number_format($economy['population']) : '-' }}
            </h4>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-dark text-light border-secondary p-3 h-100">
            <h6>Export</h6>
            <h4>
                {{ $economy['export'] ? number_format($economy['export']) : '-' }}
            </h4>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-dark text-light border-secondary p-3 h-100">
            <h6>Import</h6>
            <h4>
                {{ $economy['import'] ? number_format($economy['import']) : '-' }}
            </h4>
        </div>
    </div>

</div>

@endsection