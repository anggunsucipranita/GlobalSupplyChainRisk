@extends('layouts.master')

@section('content')

<div class="container-fluid">

<h2 class="mb-4 fw-bold text-light">

📊 Data Visualization Dashboard

</h2>

<div class="card bg-dark border-secondary shadow mb-4">

<div class="card-body">

<form method="GET">

<label class="text-light mb-2">

🌍 Select Country

</label>

<select
name="country"
class="form-select"
onchange="this.form.submit()">

@foreach($countries as $item)

<option
value="{{ $item['cca3'] }}"
{{ $country==$item['cca3'] ? 'selected' : '' }}>

{{ $item['flag'] ?? '🏳️' }}

{{ $item['name']['common'] }}

</option>

@endforeach

</select>

</form>

</div>

</div>

<div class="row">

<div class="col-lg-6 mb-4">

<div class="card bg-dark border-secondary shadow">

<div class="card-header text-info fw-bold">

📈 GDP Trend (Billion USD)

</div>

<div class="card-body">

<canvas id="gdpChart"></canvas>

</div>

</div>

</div>

<div class="col-lg-6 mb-4">

<div class="card bg-dark border-secondary shadow">

<div class="card-header text-warning fw-bold">

📊 Inflation Trend

</div>

<div class="card-body">

<canvas id="inflationChart"></canvas>

</div>

</div>

</div>

<div class="col-lg-6 mb-4">

<div class="card bg-dark border-secondary shadow">

<div class="card-header text-success fw-bold">

💱 Currency Trend

</div>

<div class="card-body">

<canvas id="currencyChart"></canvas>

</div>

</div>

</div>

<div class="col-lg-6 mb-4">

<div class="card bg-dark border-secondary shadow">

<div class="card-header text-danger fw-bold">

⚠ Risk Trend

</div>

<div class="card-body">

<canvas id="riskChart"></canvas>

</div>

</div>

</div>

</div>

</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(document.getElementById('gdpChart'),{

type:'line',

data:{

labels:@json(array_column($gdpTrend,'year')),

datasets:[{

label:'GDP',

data:@json(array_column($gdpTrend,'value')),

borderColor:'#38bdf8',

backgroundColor:'rgba(56,189,248,.2)',

fill:true,

tension:.4

}]

}

});

new Chart(document.getElementById('inflationChart'),{

type:'line',

data:{

labels:@json(array_column($inflationTrend,'year')),

datasets:[{

label:'Inflation',

data:@json(array_column($inflationTrend,'value')),

borderColor:'#facc15',

backgroundColor:'rgba(250,204,21,.2)',

fill:true,

tension:.4

}]

}

});

new Chart(document.getElementById('currencyChart'),{

type:'line',

data:{

labels:@json(array_column($currencyTrend,'day')),

datasets:[{

label:'Exchange Rate',

data:@json(array_column($currencyTrend,'value')),

borderColor:'#22c55e',

backgroundColor:'rgba(34,197,94,.2)',

fill:true,

tension:.4

}]

}

});

new Chart(document.getElementById('riskChart'),{

type:'bar',

data:{

labels:@json(array_column($riskTrend,'day')),

datasets:[{

label:'Risk',

data:@json(array_column($riskTrend,'value')),

backgroundColor:'#ef4444'

}]

},

options:{

scales:{

y:{

beginAtZero:true,

max:100

}

}

}

});

</script>

@endpush