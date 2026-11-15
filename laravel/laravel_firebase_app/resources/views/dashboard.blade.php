@extends('layouts.dashboard')

@section('page')
    Dashboard
@endsection

@section('content')
    <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
            <div class="page-heading">
                <div class="page-heading-copy">
                    <span class="page-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
                    <div>
                        <p class="eyebrow mb-1">Overview</p>
                        <h1 class="h3 mb-1">Dashboard</h1>
                        <p class="text-muted mb-0">Monitor Farmers, advisories, alerts, and crops.
                        </p>
                    </div>
                </div>
            </div>

            <section class="row g-3 mt-1" aria-label="Dashboard metrics">
                <div class="col-12 col-sm-6 col-xl-3">
                    <article class="metric-card metric-primary">
                        <div class="metric-top">
                            <span class="metric-label">Farmers</span>
                            <span class="metric-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
                        </div>
                        <div class="metric-value">{{ $totalActiveFarmers }}</div>
                        <div class="metric-meta">
                            <span class="text-primary">Active</span>
                            <span>farmers count</span>
                        </div>
                    </article>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <article class="metric-card metric-success">
                        <div class="metric-top">
                            <span class="metric-label">Crops</span>
                            <span class="metric-icon"><i class="bi bi-leaf" aria-hidden="true"></i></span>
                        </div>
                        <div class="metric-value">{{ $totalActiveCrops }}</div>
                        <div class="metric-meta">
                            <span class="text-success">Active</span>
                            <span>crops count</span>
                        </div>
                    </article>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <article class="metric-card metric-warning">
                        <div class="metric-top">
                            <span class="metric-label">Advisories</span>
                            <span class="metric-icon"><i class="bi bi-bell" aria-hidden="true"></i></span>
                        </div>
                        <div class="metric-value">{{ $totalActiveAdvisories }}</div>
                        <div class="metric-meta">
                            <span class="text-warning">Active</span>
                            <span>advisories count</span>
                        </div>
                    </article>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <article class="metric-card metric-danger">
                        <div class="metric-top">
                            <span class="metric-label">Alerts</span>
                            <span class="metric-icon"><i class="bi bi-exclamation-triangle" aria-hidden="true"></i></span>
                        </div>
                        <div class="metric-value">{{ $totalActiveAlerts }}</div>
                        <div class="metric-meta">
                            <span class="text-danger">Active</span>
                            <span>alerts count</span>
                        </div>
                    </article>
                </div>
            </section>

            <section class="row g-3 mt-1">
                {{-- <div class="col-12 col-xl-6">
                    <div class="panel">
                        <div class="panel-header">
                            <div>
                                <h2 class="h5 mb-1 section-title"><i class="bi bi-graph-up-arrow"
                                        aria-hidden="true"></i><span>Sales Performance</span></h2>
                                <p class="text-muted mb-0">Monthly revenue compared with operational targets.</p>
                            </div>
                            <a class="btn btn-light btn-sm" href="charts.html">View Details</a>
                        </div>

                        <div class="chart-bars" aria-label="Sales performance chart">
                            <div class="chart-column bar-42"><span></span><small>Jan</small></div>
                            <div class="chart-column bar-58"><span></span><small>Feb</small></div>
                            <div class="chart-column bar-51"><span></span><small>Mar</small></div>
                            <div class="chart-column bar-72"><span></span><small>Apr</small></div>
                            <div class="chart-column bar-66"><span></span><small>May</small></div>
                            <div class="chart-column bar-83"><span></span><small>Jun</small></div>
                        </div>
                    </div>
                </div> --}}

                <div class="col-12 col-xl-6">
                    <div class="panel h-100">
                        <div class="panel-header">
                            <div>
                                <h2 class="h5 mb-1 section-title"><i class="bi bi-bell" aria-hidden="true"></i><span>Recent
                                        Advisories</span></h2>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Title</th>
                                        <th scope="col" class="text-end">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($advisories as $advisory)
                                        <tr>
                                            <td>{{ $advisory->title_en }}</td>
                                            <td class="text-end">
                                                @if ($advisory->valid_until > now())
                                                    <span class="badge text-bg-success">Active</span>
                                                @else
                                                    <span class="badge text-bg-secondary">Expired</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-6">
                    <div class="panel h-100">
                        <div class="panel-header">
                            <div>
                                <h2 class="h5 mb-1 section-title"><i class="bi bi-exclamation-triangle"
                                        aria-hidden="true"></i><span>Recent Alerts</span></h2>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Title</th>
                                        <th scope="col" class="text-end">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alerts as $alert)
                                        <tr>
                                            <td>{{ $alert->title_en }}</td>
                                            <td class="text-end">
                                                @if ($alert->valid_until > now())
                                                    <span class="badge text-bg-success">Active</span>
                                                @else
                                                    <span class="badge text-bg-secondary">Expired</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            {{-- <section class="panel mt-3">
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
                                <th scope="col">User</th>
                                <th scope="col">Role</th>
                                <th scope="col">Status</th>
                                <th scope="col">Last Login</th>
                                <th scope="col">Platform</th>
                                <th scope="col" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $data)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div>
                                                <p class="fw-semibold mb-0">{{ $data['name'] }}</p>
                                                <p class="text-muted small mb-0">{{ $data['email'] }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $data['role'] }}</td>
                                    <td>
                                        @if ($data['online'] === true)
                                        <span class="badge text-bg-success">Online</span>
                                        @else
                                        <span class="badge text-bg-secondary">Offline</span>
                                        @endif
                                    </td>
                                    <td>{{ $data['last_login'] ?? '-' }}</td>
                                    <td>{{ $data['platform'] ?? '-' }}</td>
                                    <td class="text-end"><a class="btn btn-light btn-sm"
                                            href="user-details.html">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section> --}}
        </div>
    </main>
@endsection
