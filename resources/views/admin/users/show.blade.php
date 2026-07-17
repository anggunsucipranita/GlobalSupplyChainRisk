@extends('layouts.master')

@section('content')

<div class="container">

    <h2 class="mb-4 text-light fw-bold">

        👤 User Detail

    </h2>

    <div class="card bg-dark border-secondary">

        <div class="card-body">

            <table class="table table-dark">

                <tr>

                    <th width="200">ID</th>

                    <td>{{ $user->id }}</td>

                </tr>

                <tr>

                    <th>Name</th>

                    <td>{{ $user->name }}</td>

                </tr>

                <tr>

                    <th>Email</th>

                    <td>{{ $user->email }}</td>

                </tr>

                <tr>

                    <th>Created At</th>

                    <td>{{ $user->created_at }}</td>

                </tr>

                <tr>

                    <th>Updated At</th>

                    <td>{{ $user->updated_at }}</td>

                </tr>

            </table>

            <a
                href="{{ route('admin.users') }}"
                class="btn btn-secondary">

                ← Back

            </a>

        </div>

    </div>

</div>

@endsection