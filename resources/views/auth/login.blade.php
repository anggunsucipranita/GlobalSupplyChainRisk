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

        <h3 class="text-center mb-4">
            Welcome Back
        </h3>

        <form method="POST" action="{{ route('login') }}">

            @csrf

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
                    required
                    autofocus>

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
                    placeholder="Enter your password"
                    required>

                @error('password')

                    <small class="text-danger">

                        {{ $message }}

                    </small>

                @enderror

            </div>

            {{-- REMEMBER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">

                <div class="form-check">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="remember"
                        id="remember">

                    <label
                        class="form-check-label"
                        for="remember">

                        Remember Me

                    </label>

                </div>

                @if (Route::has('password.request'))

                    <a
                        href="{{ route('password.request') }}"
                        class="auth-link">

                        Forgot Password?

                    </a>

                @endif

            </div>

            {{-- BUTTON --}}
            <button
                type="submit"
                class="btn-login">

                Login

            </button>

        </form>

        {{-- REGISTER --}}
        <div class="bottom-box text-center">

            <p class="mb-2">

                Don't have an account?

            </p>

            <a
                href="{{ route('register') }}"
                class="auth-link fw-bold">

                Create Account

            </a>

        </div>

        {{-- FEATURES --}}
        <div class="feature-list">

            <div class="feature-item">

                <i class="bi bi-globe2"></i>

                <h6>

                    Global

                </h6>

                <p>

                    Monitor Countries

                </p>

            </div>

            <div class="feature-item">

                <i class="bi bi-bar-chart-line"></i>

                <h6>

                    Analytics

                </h6>

                <p>

                    Risk Dashboard

                </p>

            </div>

            <div class="feature-item">

                <i class="bi bi-shield-check"></i>

                <h6>

                    Security

                </h6>

                <p>

                    Protected Access

                </p>

            </div>

        </div>

        <div class="footer-text">

            © {{ date('Y') }}

            Global Supply Chain Risk Intelligence Platform

        </div>

    </div>

</div>

@endsection