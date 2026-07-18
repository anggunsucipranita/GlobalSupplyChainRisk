@extends('layouts.master')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold text-light">
            ⚓ Port Management
        </h2>

        <a href="{{ route('admin.ports.create') }}"
           class="btn btn-success">
            ➕ Add Port
        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    <div class="card bg-dark border-secondary">

        <div class="card-header text-info fw-bold">
            Port List
        </div>

        <div class="card-body">

            <table class="table table-dark table-hover align-middle">

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>Port</th>

                        <th>Country</th>

                        <th>City</th>

                        <th>Latitude</th>

                        <th>Longitude</th>

                        <th>Size</th>

                        <th>Status</th>

                        <th width="220">Action</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($ports as $port)

                    <tr>

                        <td>{{ $port->id }}</td>

                        <td>{{ $port->name }}</td>

                        <td>{{ $port->country }}</td>

                        <td>{{ $port->city }}</td>

                        <td>{{ $port->latitude }}</td>

                        <td>{{ $port->longitude }}</td>

                        <td>{{ ucfirst($port->size) }}</td>

                        <td>

                            <span class="badge bg-success">

                                {{ $port->status }}

                            </span>

                        </td>

                        <td>

                            <a href="{{ route('admin.ports.edit', $port->id) }}"
                               class="btn btn-warning btn-sm">

                                Edit

                            </a>

                            <form action="{{ route('admin.ports.destroy', $port->id) }}"
                                  method="POST"
                                  style="display:inline;">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete this port?')">

                                    Delete

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="9" class="text-center">

                            No Port Found

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection