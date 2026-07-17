@extends('layouts.master')

@section('content')

<div class="container">

    <h2 class="mb-4 text-light">

        ➕ Add New Article

    </h2>

    <div class="card bg-dark border-secondary shadow">

        <div class="card-body">

            <form action="{{ route('admin.articles.store') }}" method="POST">

                @csrf

                <div class="mb-3">

                    <label class="form-label text-light">

                        Title

                    </label>

                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label text-light">

                        Category

                    </label>

                    <select
                        name="category"
                        class="form-select"
                        required>

                        <option value="">-- Select Category --</option>

                        <option value="Economy">Economy</option>

                        <option value="Logistics">Logistics</option>

                        <option value="Weather">Weather</option>

                        <option value="Currency">Currency</option>

                        <option value="Supply Chain">Supply Chain</option>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label text-light">

                        Author

                    </label>

                    <input
                        type="text"
                        name="author"
                        class="form-control">

                </div>

                <div class="mb-3">

                    <label class="form-label text-light">

                        Publish Date

                    </label>

                    <input
                        type="date"
                        name="published_at"
                        class="form-control">

                </div>

                <div class="mb-3">

                    <label class="form-label text-light">

                        Content

                    </label>

                    <textarea
                        name="content"
                        rows="8"
                        class="form-control"
                        required></textarea>

                </div>

                <div class="mt-4">

                    <button class="btn btn-success">

                        Save Article

                    </button>

                    <a
                        href="{{ route('admin.articles') }}"
                        class="btn btn-secondary">

                        Cancel

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection