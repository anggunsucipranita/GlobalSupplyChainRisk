@extends('layouts.master')

@section('content')

<div class="container">

    <h2 class="mb-4 text-light fw-bold">

        ✏️ Edit User

    </h2>

    <div class="card bg-dark border-secondary">

        <div class="card-body">

            <form
                action="{{ route('admin.users.update', $user->id) }}"
                method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label class="form-label text-light">

                        Name

                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $user->name) }}"
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
                        value="{{ old('email', $user->email) }}"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label text-light">

                        Password
                        <small class="text-secondary">
                            (Kosongkan jika tidak ingin mengubah password)
                        </small>

                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control">

                </div>

                <button
                    type="submit"
                    class="btn btn-warning">

                    💾 Update User

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