@extends('layouts.master')

@section('content')

<div class="container">

    <h2 class="mb-4 text-light fw-bold">

        📰 Article Detail

    </h2>

    <div class="card bg-dark border-secondary shadow">

        <div class="card-body">

            <table class="table table-dark">

                <tr>

                    <th width="200">ID</th>

                    <td>{{ $article->id }}</td>

                </tr>

                <tr>

                    <th>Title</th>

                    <td>{{ $article->title }}</td>

                </tr>

                <tr>

                    <th>Category</th>

                    <td>{{ $article->category }}</td>

                </tr>

                <tr>

                    <th>Author</th>

                    <td>{{ $article->author ?? '-' }}</td>

                </tr>

                <tr>

                    <th>Publish Date</th>

                    <td>{{ $article->published_at ?? '-' }}</td>

                </tr>

                <tr>

                    <th>Content</th>

                    <td style="white-space: pre-line;">

                        {{ $article->content }}

                    </td>

                </tr>

                <tr>

                    <th>Created At</th>

                    <td>{{ $article->created_at }}</td>

                </tr>

                <tr>

                    <th>Updated At</th>

                    <td>{{ $article->updated_at }}</td>

                </tr>

            </table>

            <a
                href="{{ route('admin.articles') }}"
                class="btn btn-secondary">

                ← Back

            </a>

        </div>

    </div>

</div>

@endsection