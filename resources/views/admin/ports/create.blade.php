@extends('layouts.master')

@section('content')

<div class="container">

<h2 class="mb-4 text-light">

➕ Add New Port

</h2>

<div class="card bg-dark border-secondary">

<div class="card-body">

<form action="{{ route('admin.ports.store') }}" method="POST">

@csrf

<div class="mb-3">

<label class="text-light">Port Name</label>

<input
type="text"
name="name"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="text-light">Country</label>

<input
type="text"
name="country"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="text-light">City</label>

<input
type="text"
name="city"
class="form-control">

</div>

<div class="row">

<div class="col-md-6">

<label class="text-light">

Latitude

</label>

<input
type="text"
name="latitude"
class="form-control">

</div>

<div class="col-md-6">

<label class="text-light">

Longitude

</label>

<input
type="text"
name="longitude"
class="form-control">

</div>

</div>

<div class="mt-3">

<label class="text-light">

Status

</label>

<select
name="status"
class="form-select">

<option>Active</option>

<option>Inactive</option>

</select>

</div>

<div class="mt-4">

<button class="btn btn-success">

Save Port

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