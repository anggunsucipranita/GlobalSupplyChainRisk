@extends('layouts.master')

@section('content')

<div class="container">

<h2 class="mb-4 text-light">

✏️ Edit Port

</h2>

<div class="card bg-dark border-secondary">

<div class="card-body">

<form
action="{{ route('admin.ports.update',$port->id) }}"
method="POST">

@csrf
@method('PUT')

<div class="mb-3">

<label class="text-light">

Port Name

</label>

<input
type="text"
name="name"
class="form-control"
value="{{ $port->name }}"
required>

</div>

<div class="mb-3">

<label class="text-light">

Country

</label>

<input
type="text"
name="country"
class="form-control"
value="{{ $port->country }}"
required>

</div>

<div class="mb-3">

<label class="text-light">

City

</label>

<input
type="text"
name="city"
class="form-control"
value="{{ $port->city }}">

</div>

<div class="row">

<div class="col-md-6">

<label class="text-light">

Latitude

</label>

<input
type="text"
name="latitude"
class="form-control"
value="{{ $port->latitude }}">

</div>

<div class="col-md-6">

<label class="text-light">

Longitude

</label>

<input
type="text"
name="longitude"
class="form-control"
value="{{ $port->longitude }}">

</div>

</div>

<div class="mt-3">

<label class="text-light">

Status

</label>

<select
name="status"
class="form-select">

<option
value="Active"
{{ $port->status=='Active'?'selected':'' }}>

Active

</option>

<option
value="Inactive"
{{ $port->status=='Inactive'?'selected':'' }}>

Inactive

</option>

</select>

</div>

<div class="mt-4">

<button class="btn btn-warning">

Update Port

</button>

<a
href="{{ route('admin.ports') }}"
class="btn btn-secondary">

Cancel

</a>

</div>

</form>

</div>

</div>

</div>

@endsection