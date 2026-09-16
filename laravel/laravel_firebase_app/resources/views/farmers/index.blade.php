@extends('layouts.dashboard')

@section('page') Farmers Profile @endsection

@section('content')
    <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
            <div class="page-heading">
                <div class="page-heading-copy">
                    <span class="page-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
                    <div>
                        <p class="eyebrow mb-1">Management</p>
                        <h1 class="h3 mb-1">Farmers Profile</h1>
                        <p class="text-muted mb-0">Monitor performance, sales, users, and support from one clean workspace.
                        </p>
                    </div>
                </div>
                <div class="heading-actions"><button class="btn btn-outline-secondary btn-sm" type="button"><i
                            class="bi bi-download" aria-hidden="true"></i> Export</button><button
                        class="btn btn-primary btn-sm" type="button"><i class="bi bi-file-earmark-plus"
                            aria-hidden="true"></i> Create Report</button></div>
            </div>


            <section class="panel mt-3">
                <div class="panel-header">
                    <div>
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-people" aria-hidden="true"></i><span>Recent
                                Users</span></h2>
                        <p class="text-muted mb-0">Latest account activity across the workspace.</p>
                    </div>
                    <a class="btn btn-outline-secondary btn-sm" href="users.html">Manage Users</a>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Location</th>
                                <th scope="col">Platform</th>
                                <th scope="col">Language</th>
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
                                                <p class="fw-semibold mb-0">{{ $data['name'] ?? '-' }}</p>
                                                <p class="text-muted small mb-0">{{ $data['phone'] ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $data['location']['city'] ?? '-' }}</td>
                                    <td>{{ $data['platform'] ?? '-' }}</td>
                                    <td>{{ $data['language'] ?? '-' }}</td>
                                    <td>
                                        @if ($data['online'] === true)
                                            <span class="badge text-bg-success">Online</span>
                                        @else
                                            <span class="badge text-bg-secondary">Offline</span>
                                        @endif
                                    </td>
                                    <td class="text-end"><a class="btn btn-light btn-sm" href="">View</a>
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
