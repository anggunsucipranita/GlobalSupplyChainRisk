@extends('layouts.master')

@section('content')

<div class="container-fluid">

    <h2 class="mb-4 fw-bold text-light">
        ⚙️ Admin Dashboard
    </h2>

    <div class="row g-4">

        <div class="col-lg-3 col-md-6">

            <div class="card bg-dark border-primary shadow h-100">

                <div class="card-body text-center">

                    <h6 class="text-info">
                        👤 Total Users
                    </h6>

                    <h2 class="fw-bold text-light">
                        {{ $totalUsers }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card bg-dark border-success shadow h-100">

                <div class="card-body text-center">

                    <h6 class="text-success">
                        🌍 Countries
                    </h6>

                    <h2 class="fw-bold text-light">
                        {{ $totalCountries }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card bg-dark border-warning shadow h-100">

                <div class="card-body text-center">

                    <h6 class="text-warning">
                        ⭐ Favorite Monitoring
                    </h6>

                    <h2 class="fw-bold text-light">
                        {{ $totalWatchlists }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card bg-dark border-danger shadow h-100">

                <div class="card-body text-center">

                    <h6 class="text-danger">
                        ⚓ Ports
                    </h6>

                    <h2 class="fw-bold text-light">
                        {{ $totalPorts }}
                    </h2>

                </div>

            </div>

        </div>

    </div>

    <div class="row g-4 mt-1">

        <div class="col-lg-6">

            <div class="card bg-dark border-secondary shadow">

                <div class="card-header fw-bold text-info">

                    📊 System Summary

                </div>

                <div class="card-body text-light">

                    <p>👤 Registered Users :
                        <strong>{{ $totalUsers }}</strong>
                    </p>

                    <p>🌍 Countries :
                        <strong>{{ $totalCountries }}</strong>
                    </p>

                    <p>⭐ Favorite Monitoring :
                        <strong>{{ $totalWatchlists }}</strong>
                    </p>

                    <p>⚓ Port Dataset :
                        <strong>{{ $totalPorts }}</strong>
                    </p>

                    <p>📰 Articles :
                        <strong>{{ $totalArticles }}</strong>
                    </p>

                </div>

            </div>

        </div>

        <div class="col-lg-6">

            <div class="card bg-dark border-secondary shadow">

                <div class="card-header fw-bold text-warning">

                    🚀 Quick Menu

                </div>

                <div class="card-body">

                    <div class="d-grid gap-2">

                        <a href="{{ route('watchlists.index') }}" class="btn btn-outline-warning">
                            ⭐ Favorite Monitoring
                        </a>

                        <a href="{{ route('countries') }}" class="btn btn-outline-success">
                            🌍 Countries
                        </a>

                        <a href="{{ route('ports') }}" class="btn btn-outline-info">
                            ⚓ Port Dashboard
                        </a>

                        <a href="{{ route('news') }}" class="btn btn-outline-primary">
                            📰 News Dashboard
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection