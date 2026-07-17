@extends('layouts.master')

@section('content')

<div class="container-fluid">

<h2 class="mb-4 fw-bold text-light">
⭐ Favorite Monitoring
</h2>

@if(session('success'))

<div class="alert alert-success">

{{ session('success') }}

</div>

@endif

@if($watchlists->isEmpty())

<div class="alert alert-warning">

No favorite country yet.

</div>

@else

<div class="row g-4">

@foreach($watchlists as $watchlist)

<div class="col-lg-4">

<div class="card bg-dark border-secondary shadow h-100">

<div class="card-body">

<h4 class="text-info">

{{ $watchlist->country_name }}

</h4>

<p class="text-secondary">

Country Code :
<strong>

{{ $watchlist->country_code }}

</strong>

</p>

<a
href="{{ route('dashboard',['country'=>$watchlist->country_code]) }}"
class="btn btn-outline-info w-100 mb-2">

Open Dashboard

</a>

<form
action="{{ route('watchlists.destroy',$watchlist->id) }}"
method="POST">

@csrf
@method('DELETE')

<button
class="btn btn-outline-danger w-100">

Remove Favorite

</button>

</form>

</div>

</div>

</div>

@endforeach

</div>

@endif

</div>

@endsection