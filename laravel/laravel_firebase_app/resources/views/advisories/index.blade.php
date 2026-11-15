@extends('layouts.dashboard')

@section('page')
    Advisories List
@endsection

@section('content')
    <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
            <div class="page-heading">
                <div class="page-heading-copy">
                    <span class="page-icon"><i class="bi bi-bell" aria-hidden="true"></i></span>
                    <div>
                        <p class="eyebrow mb-1">List</p>
                        <h1 class="h3 mb-1">Advisory List</h1>
                        <p class="text-muted mb-0">All advisories in the system.</p>
                    </div>
                </div>
                <div class="heading-actions">
                    {{-- <button class="btn btn-outline-secondary btn-sm" type="button"><i class="bi bi-download"
                            aria-hidden="true"></i> Export</button> --}}
                    @can('manage advisories')
                        <a class="btn btn-primary btn-sm" href="{{ route('advisories.create') }}"><i class="bi bi-plus"
                                aria-hidden="true"></i> Create Advisory</a>
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

            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-bell" aria-hidden="true"></i><span>Advisory
                                Details</span></h2>
                        <p class="text-muted mb-0">Manage and view all advisories in the system.</p>
                    </div>
                    <input class="form-control form-control-sm table-search" type="search" placeholder="Search advisory"
                        data-table-search="advisoryTable" aria-label="Search advisory">
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0" id="advisoryTable" data-searchable-table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                {{-- <th>State</th> --}}
                                <th>Created By</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($advisories as $advisory)
                                <tr>
                                    <td>
                                        {{ $advisory->title_en }}
                                    </td>

                                    <td>{{ Str::words($advisory->description_en, 7, '...') }}</td>

                                    {{-- <td>{{ $advisory->state ?? 'All States' }}</td> --}}

                                    <td>{{ $advisory->creator?->name ?? '-' }}</td>

                                    <td>
                                        @if ($advisory->valid_from <= now() && $advisory->valid_until >= now())
                                            <span class="badge bg-success">Active</span>
                                        @elseif ($advisory->valid_from > now())
                                            <span class="badge bg-warning">Upcoming</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>

                                    <td class="d-flex justify-content-end">
                                        <a class="btn btn-light btn-sm"
                                            href="{{ route('advisories.show', $advisory->id) }}"><i
                                                class="bi bi-eye"></i></a>

                                        @can('manage advisories')
                                            @if (!$advisory->trashed())
                                                <form action="{{ route('advisories.destroy', $advisory->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-light btn-sm ms-1" type="submit"><i
                                                            class="bi bi-trash3"></i></button>
                                                </form>
                                            @else
                                                <form action="{{ route('advisories.restore', $advisory->id) }}" method="post">
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
