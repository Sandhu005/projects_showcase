@extends('layouts.dashboard')

@section('page')
    Users
@endsection

@section('content')
    <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
            <div class="page-heading">
                <div class="page-heading-copy">
                    <span class="page-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
                    <div>
                        <p class="eyebrow mb-1">Management</p>
                        <h1 class="h3 mb-1">Users List</h1>
                        <p class="text-muted mb-0">Admin panel users in the system.
                        </p>
                    </div>
                </div>
                <div class="heading-actions">
                    {{-- <button class="btn btn-outline-secondary btn-sm" type="button"><i class="bi bi-download"
                            aria-hidden="true"></i> Export
                    </button> --}}
                    @can('manage users')
                        <a class="btn btn-primary btn-sm" href="{{ route('users.create') }}"><i class="bi bi-person-plus"
                                aria-hidden="true"></i> Add User</a>
                    @endcan
                </div>
            </div>

            @if (Session::get('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @elseif($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <section class="panel mt-3">
                <div class="panel-header">
                    <div>
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-people" aria-hidden="true"></i><span>All
                                Users</span></h2>
                        <p class="text-muted mb-0">All account activity across the admin panel.</p>
                    </div>
                    <input class="form-control form-control-sm table-search" type="search" placeholder="Search User"
                        data-table-search="usersTable" aria-label="Search User">
                </div>
                <div class="table-responsive">
                    <table class="table align-middle" mb-0 id="usersTable" data-searchable-table>
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Role</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $data)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div>
                                                <p class="fw-semibold mb-0">{{ $data->name }}</p>
                                                <p class="text-muted small mb-0">{{ $data->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $data->phone }}</td>
                                    <td>{{ ucfirst($data->getRoleNames()->first()) }}</td>
                                    <td>
                                        @if ($data->status === 'active')
                                            <span class="badge text-bg-success">Active</span>
                                        @else
                                            <span class="badge text-bg-danger">Blocked</span>
                                        @endif
                                    </td>
                                    <td class="d-flex justify-content-end">
                                        <a class="btn btn-light btn-sm" href="{{ route('users.show', $data->id) }}"><i
                                                class="bi bi-eye"></i></a>

                                        @can('manage users')
                                            @if (!$data->trashed())
                                                <form action="{{ route('users.destroy', $data->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-light btn-sm ms-1" type="submit"><i
                                                            class="bi bi-trash3"></i></button>
                                                </form>
                                            @else
                                                <form action="{{ route('users.restore', $data->id) }}" method="post">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="btn btn-light btn-sm ms-1" type="submit"><i
                                                            class="bi bi-arrow-clockwise"></i></button>
                                                </form>
                                            @endif
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
@endsection
