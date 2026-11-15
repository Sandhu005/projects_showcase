@extends('layouts.dashboard')

@section('page')
    Alerts List
@endsection

@section('content')
    <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
            <div class="page-heading">
                <div class="page-heading-copy">
                    <span class="page-icon"><i class="bi bi-exclamation-triangle" aria-hidden="true"></i></span>
                    <div>
                        <p class="eyebrow mb-1">List</p>
                        <h1 class="h3 mb-1">Alert List</h1>
                        <p class="text-muted mb-0">All alerts in the system.</p>
                    </div>
                </div>
                @can('manage alerts')
                    <a class="btn btn-primary btn-sm" href="{{ route('alerts.create') }}"><i class="bi bi-plus-lg"
                            aria-hidden="true"></i> Create Alert</a>
                @endcan
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-exclamation-triangle"
                                aria-hidden="true"></i><span>Alert Details</span></h2>
                        <p class="text-muted mb-0">Manage and view all alerts in the system.</p>
                    </div>
                    <input class="form-control form-control-sm table-search" type="search" placeholder="Search alerts"
                        data-table-search="alertTable" aria-label="Search alerts">
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0" id="alertTable" data-searchable-table>
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
                            @forelse ($alerts as $alert)
                                <tr>
                                    <td>{{ $alert->title_en }}</td>
                                    <td>{{ Str::words($alert->description_en, 7, '...') }}</td>
                                    {{-- <td>{{ $alert->state ?? 'All states' }}</td> --}}
                                    <td>{{ $alert->creator?->name ?? '-' }}</td>
                                    <td>
                                        @if ($alert->valid_from <= now() && $alert->valid_until >= now())
                                            <span class="badge bg-success">Active</span>
                                        @elseif ($alert->valid_from > now())
                                            <span class="badge bg-warning">Upcoming</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="d-flex justify-content-end">
                                        <a class="btn btn-light btn-sm" href="{{ route('alerts.show', $alert->id) }}"
                                            aria-label="View alert"><i class="bi bi-eye"></i></a>
                                        @can('manage alerts')
                                            @if (!$alert->trashed())
                                                <form action="{{ route('alerts.destroy', $alert->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-light btn-sm ms-1" type="submit"
                                                        aria-label="Delete alert"><i class="bi bi-trash3"></i></button>
                                                </form>
                                            @else
                                                <form action="{{ route('alerts.restore', $alert->id) }}" method="post">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="btn btn-light btn-sm ms-1" type="submit"
                                                        aria-label="Restore alert"><i
                                                            class="bi bi-arrow-clockwise"></i></button>
                                                </form>
                                            @endif
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No alerts found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
@endsection
