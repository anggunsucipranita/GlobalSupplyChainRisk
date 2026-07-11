@extends('layouts.auth')

@section('content')

<div class="auth-wrapper">

    <div class="auth-card">

        <div class="logo-icon">
            🌍
        </div>

        <h1 class="logo-title">
            GLOBAL <span>SUPPLY CHAIN</span>
        </h1>

        <p class="logo-sub">
            Risk Intelligence Platform
            <br>
            Monitor Global Logistics & Business Risk
        </p>

        <div class="divider"></div>

        <h3 class="text-center mb-3">
            Create Account
        </h3>

        <form method="POST" action="{{ route('register') }}">

            @csrf

            {{-- NAME --}}
            <div class="mb-3">

                <label class="form-label">
                    Full Name
                </label>

                <input
                    type="text"
                    name="name"
                    class="form-control"
                    placeholder="Enter your full name"
                    value="{{ old('name') }}"
                    required
                    autofocus>

                @error('name')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                @enderror

            </div>

            {{-- EMAIL --}}
            <div class="mb-3">

                <label class="form-label">
                    Email Address
                </label>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    placeholder="Enter your email"
                    value="{{ old('email') }}"
                    required>

                @error('email')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                @enderror

            </div>

            {{-- PASSWORD --}}
            <div class="mb-3">

                <label class="form-label">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Create password"
                    required>

                @error('password')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                @enderror

            </div>

            {{-- CONFIRM PASSWORD --}}
            <div class="mb-3">

                <label class="form-label">
                    Confirm Password
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    class="form-control"
                    placeholder="Confirm password"
                    required>

            </div>

            <button
                type="submit"
                class="btn-login">

                Register

            </button>

        </form>

        <div class="bottom-box">

            <p class="mb-2">

                Already have an account?

            </p>

            <a
                href="{{ route('login') }}"
                class="auth-link fw-bold">

                Login Here

            </a>

        </div>

        <div class="footer-text">

            © {{ date('Y') }}

            Global Supply Chain Risk Intelligence Platform

        </div>

    </div>

</div>

@endsection