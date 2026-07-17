@extends('layouts.master')

@section('content')

<div class="container">

    <h2 class="mb-4 text-light fw-bold">

        ➕ Add New User

    </h2>

    <div class="card bg-dark border-secondary">

        <div class="card-body">

            <form
                action="{{ route('admin.users.store') }}"
                method="POST">

                @csrf

                <div class="mb-3">

                    <label class="form-label text-light">

                        Name

                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label text-light">

                        Email

                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label text-light">

                        Password

                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        required>

                </div>

                <button
                    class="btn btn-success">

                    Save User

                </button>

                <a
                    href="{{ route('admin.users') }}"
                    class="btn btn-secondary">

                    Cancel

                </a>

            </form>

        </div>

    </div>

</div>

@endsection