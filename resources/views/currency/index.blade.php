@extends('layouts.master')

@section('content')

<h2 class="fw-bold text-light mb-4">
    💱 Currency Dashboard
</h2>

@if(isset($currency['rates']))

<div class="row g-3">

    <div class="col-md-3">
        <div class="card bg-dark text-light border-secondary p-3">
            <h6>USD → IDR</h6>
            <h3 class="text-warning">
                {{ number_format($currency['rates']['IDR'],2) }}
            </h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-dark text-light border-secondary p-3">
            <h6>USD → EUR</h6>
            <h3 class="text-info">
                {{ $currency['rates']['EUR'] }}
            </h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-dark text-light border-secondary p-3">
            <h6>USD → JPY</h6>
            <h3 class="text-success">
                {{ $currency['rates']['JPY'] }}
            </h3>
        </div>
    </div>

</div>

@else

<div class="alert alert-warning">
    Data kurs tidak tersedia.
</div>

@endif

@endsection