@extends('layouts.master')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="fw-bold text-light mb-0">
        👤 User Management
    </h2>

    <a
        href="{{ route('admin.users.create') }}"
        class="btn btn-success">

        ➕ Add User

    </a>

</div>

    <div class="card bg-dark border-secondary shadow">

        <div class="card-header fw-bold text-info">
            Registered Users
        </div>

        <div class="card-body">

            <table class="table table-dark table-hover align-middle">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th width="320">Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($users as $user)

                        <tr>

                            <td>{{ $user->id }}</td>

                            <td>{{ $user->name }}</td>

                            <td>{{ $user->email }}</td>

                            <td>{{ $user->created_at->format('d M Y') }}</td>

                            <td>

                                <a
                                    href="{{ route('admin.users.show',$user->id) }}"
                                    class="btn btn-sm btn-info">

                                    View

                                </a>

                                <a
                                    href="{{ route('admin.users.edit',$user->id) }}"
                                    class="btn btn-sm btn-warning">

                                    Edit

                                </a>

                                <form
                                    action="{{ route('admin.users.destroy',$user->id) }}"
                                    method="POST"
                                    style="display:inline;">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this user?')">

                                        Delete

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="text-center">

                                No User Found

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection