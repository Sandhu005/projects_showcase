@extends('layouts.dashboard')

@section('page')
    Crops List
@endsection

@section('content')
    <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
            <div class="page-heading">
                <div class="page-heading-copy">
                    <span class="page-icon"><i class="bi bi-card-checklist" aria-hidden="true"></i></span>
                    <div>
                        <p class="eyebrow mb-1">List</p>
                        <h1 class="h3 mb-1">Seeds List</h1>
                        <p class="text-muted mb-0">All seeds in the system.</p>
                    </div>
                </div>
                <div class="heading-actions"><button class="btn btn-outline-secondary btn-sm" type="button"><i
                            class="bi bi-download" aria-hidden="true"></i> Export</button><button
                        class="btn btn-primary btn-sm" type="button"><i class="bi bi-file-earmark-plus"
                            aria-hidden="true"></i> Create Report</button>
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
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-card-checklist" aria-hidden="true"></i><span>Seeds
                                Details</span></h2>
                        <p class="text-muted mb-0">Manage and view all seeds in the system.</p>
                    </div><input class="form-control form-control-sm table-search" type="search" placeholder="Search seeds"
                        data-table-search="seedsTable" aria-label="Search seeds">
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0" id="ordersTable" data-searchable-table>
                        <thead>
                            <tr>
                                <th>Crop</th>
                                <th>Seed</th>
                                <th>Days</th>
                                <th>Season</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($seeds as $seed)
                                <tr>
                                    <td> {{ $seed->crop->crop_name }} </td>

                                    <td>{{ $seed->seed_name }}</td>

                                    <td>{{ $seed->maturity_days }}</td>

                                    <td>{{ $seed->season }}</td>

                                    <td>{{ Str::words($seed->seed_description, 10, '...') ?? '-' }}</td>

                                    <td>
                                        @if ($seed->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif

                                    <td class="d-flex justify-content-end">
                                        <a class="btn btn-light btn-sm" href="{{ route('seeds.show', $seed->id) }}"><i
                                                class="bi bi-eye"></i></a>

                                        @can('manage seeds')
                                            @if ($seed->status == 'active')
                                                <form action="{{ route('seeds.destroy', $seed->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-light btn-sm ms-1" type="submit"><i
                                                            class="bi bi-trash3"></i></button>
                                                </form>
                                            @else
                                                <form action="{{ route('seeds.restore', $seed->id) }}" method="post">
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
