@extends('layouts.master')

@section('content')

<div class="container">

    <h2 class="mb-4 text-light">

        ✏️ Edit Article

    </h2>

    <div class="card bg-dark border-secondary shadow">

        <div class="card-body">

            <form
                action="{{ route('admin.articles.update',$article->id) }}"
                method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label class="form-label text-light">

                        Title

                    </label>

                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        value="{{ old('title',$article->title) }}"
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

                        <option value="Economy"
                            {{ $article->category=='Economy'?'selected':'' }}>
                            Economy
                        </option>

                        <option value="Logistics"
                            {{ $article->category=='Logistics'?'selected':'' }}>
                            Logistics
                        </option>

                        <option value="Weather"
                            {{ $article->category=='Weather'?'selected':'' }}>
                            Weather
                        </option>

                        <option value="Currency"
                            {{ $article->category=='Currency'?'selected':'' }}>
                            Currency
                        </option>

                        <option value="Supply Chain"
                            {{ $article->category=='Supply Chain'?'selected':'' }}>
                            Supply Chain
                        </option>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label text-light">

                        Author

                    </label>

                    <input
                        type="text"
                        name="author"
                        class="form-control"
                        value="{{ old('author',$article->author) }}">

                </div>

                <div class="mb-3">

                    <label class="form-label text-light">

                        Publish Date

                    </label>

                    <input
                        type="date"
                        name="published_at"
                        class="form-control"
                        value="{{ $article->published_at }}">

                </div>

                <div class="mb-3">

                    <label class="form-label text-light">

                        Content

                    </label>

                    <textarea
                        name="content"
                        rows="8"
                        class="form-control"
                        required>{{ old('content',$article->content) }}</textarea>

                </div>

                <div class="mt-4">

                    <button class="btn btn-warning">

                        Update Article

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