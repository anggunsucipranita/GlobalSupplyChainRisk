@extends('layouts.master')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold text-light">

            📰 Article Management

        </h2>

        <a
            href="{{ route('admin.articles.create') }}"
            class="btn btn-success">

            ➕ Add Article

        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <div class="card bg-dark border-secondary shadow">

        <div class="card-header fw-bold text-info">

            Article List

        </div>

        <div class="card-body">

            <table class="table table-dark table-hover align-middle">

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>Title</th>

                        <th>Category</th>

                        <th>Author</th>

                        <th>Published</th>

                        <th width="250">Action</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($articles as $article)

                    <tr>

                        <td>{{ $article->id }}</td>

                        <td>{{ $article->title }}</td>

                        <td>{{ $article->category }}</td>

                        <td>{{ $article->author ?? '-' }}</td>

                        <td>{{ $article->published_at ?? '-' }}</td>

                        <td>

                            <a
                                href="{{ route('admin.articles.show',$article->id) }}"
                                class="btn btn-info btn-sm">

                                View

                            </a>

                            <a
                                href="{{ route('admin.articles.edit',$article->id) }}"
                                class="btn btn-warning btn-sm">

                                Edit

                            </a>

                            <form
                                action="{{ route('admin.articles.destroy',$article->id) }}"
                                method="POST"
                                class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this article?')">

                                    Delete

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="text-center">

                            No Article Found

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection