@extends('layouts.dashboard')

@section('page')
    User Details
@endsection

@section('content')
    <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
            <div class="page-heading">
                <div class="page-heading-copy">
                    <span class="page-icon"><i class="bi bi-person-lines-fill" aria-hidden="true"></i></span>
                    <div>
                        <p class="eyebrow mb-1">Management</p>
                        <h1 class="h3 mb-1">User Details</h1>
                        <p class="text-muted mb-0">Inspect account status, profile data, permissions, and recent activity.
                        </p>
                    </div>
                </div>

                <div class="heading-actions">
                    <a class="btn btn-outline-secondary btn-sm" href="{{ route('users.index') }}"><i
                            class="bi bi-arrow-left" aria-hidden="true"></i> Back to
                        Users</a>

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
            @elseif ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <section class="row g-3">
                <div class="col-12 col-xl-4">
                    <div class="panel h-100 text-center profile-card">
                        <div class="profile-cover"><img src="{{ url('images/png/dasher-ui-bootstrap-5.jpg') }}"
                                alt="User workspace preview"></div>
                        <div class="profile-hero">
                            {{-- <img class="avatar-img avatar-xl profile-photo" src="../assets/images/avatar/avatar-1.jpg"
                            alt="Sarah Ahmed"> --}}
                            <h2 class="h5 mb-1">{{ $data->name }}</h2>
                            <p class="text-muted mb-3">{{ ucfirst($data->getRoleNames()->first()) }}</p>
                            @if ($data->status === 'active')
                                <span class="badge text-bg-success">Active Account</span>
                            @else
                                <span class="badge text-bg-danger">Blocked Account</span>
                            @endif
                        </div>
                        <div class="info-list mt-4 text-start">
                            <div><span>Email</span><strong>{{ $data->email }}</strong></div>
                            <div><span>Phone</span><strong>+91 {{ $data->phone }}</strong></div>
                            <div><span>Department</span><strong>Research</strong></div>
                            <div><span>Designation</span><strong>Faculty</strong></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-8">
                    <div class="panel mb-3">
                        <div class="panel-header">
                            <div>
                                <h2 class="h5 mb-1 section-title"><i class="bi bi-person-lines-fill"
                                        aria-hidden="true"></i><span>Account Overview</span></h2>
                                <p class="text-muted mb-0">Permissions, plan, and current access details.</p>
                            </div>

                            @can('manage users')
                                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal"
                                    data-bs-target="#formModal">Edit User</button>
                            @endcan

                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="mini-card">
                                    <span>Role</span><strong>{{ ucfirst($data->getRoleNames()->first()) }}</strong></div>
                            </div>
                            <div class="col-md-4">
                                <div class="mini-card"><span>Last Login</span><strong>Today</strong></div>
                            </div>
                            <div class="col-md-4">
                                <div class="mini-card"><span>Projects</span><strong>14 Active</strong></div>
                            </div>
                        </div>
                    </div>
                    <div class="panel">
                        <div class="panel-header">
                            <div>
                                <h2 class="h5 mb-1 section-title"><i class="bi bi-clock-history"
                                        aria-hidden="true"></i><span>Recent Activity</span></h2>
                                <p class="text-muted mb-0">Latest security and workflow events.</p>
                            </div>
                        </div>
                        <div class="activity-list">
                            <div class="activity-item"><span class="activity-dot bg-primary"></span>
                                <div>
                                    <p class="mb-1 fw-semibold">Updated billing permissions</p>
                                    <p class="text-muted small mb-0">2 hours ago</p>
                                </div>
                            </div>
                            <div class="activity-item"><span class="activity-dot bg-success"></span>
                                <div>
                                    <p class="mb-1 fw-semibold">Approved new teammate</p>
                                    <p class="text-muted small mb-0">Yesterday</p>
                                </div>
                            </div>
                            <div class="activity-item"><span class="activity-dot bg-warning"></span>
                                <div>
                                    <p class="mb-1 fw-semibold">Changed password</p>
                                    <p class="text-muted small mb-0">Apr 30, 2026</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    @can('manage users')
        {{-- Edit Form Model --}}
        <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form class="panel needs-validation" novalidate action="{{ route('users.update', $data->id) }}"
                        method="post">
                        @csrf
                        @method('PATCH')
                        <div class="panel-header">
                            <div>
                                <h2 class="h5 mb-1 section-title"><i class="bi bi-person-plus"
                                        aria-hidden="true"></i><span>Update User Details</span></h2>
                                <p class="text-muted mb-0">Update user account with validated fields.</p>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label" for="name">Name</label><input
                                    class="form-control" id="name" name="name" type="text"
                                    value="{{ old('name', $data->name) }}" required>
                                <div class="invalid-feedback">Name is required.</div>
                            </div>

                            <div class="col-md-6"><label class="form-label" for="email">Email</label><input
                                    class="form-control" id="email" name="email" type="email"
                                    value="{{ old('email', $data->email) }}" required>
                                <div class="invalid-feedback">Enter a valid email.</div>
                            </div>
                            <div class="col-md-6"><label class="form-label" for="phone">Phone</label><input
                                    class="form-control" id="phone" name="phone" type="tel" max="10"
                                    pattern="[6-9][0-9]{9}" value="{{ old('phone', $data->phone) }}" required>
                                <div class="invalid-feedback">Invalid Number.</div>
                            </div>
                            <div class="col-md-6"><label class="form-label" for="role">Role</label><select
                                    class="form-select" id="role" name="role" required>
                                    <option value="">Choose role</option>
                                    <option value="admin" @selected(old('role', $data->role) == 'admin')>Admin</option>
                                    <option value="editor" @selected(old('role', $data->role) == 'editor')>Editor</option>
                                </select>
                                <div class="invalid-feedback">Choose a role.</div>
                            </div>
                            {{-- <div class="col-md-6"><label class="form-label" for="password">Password</label><input
                                class="form-control" id="password" name="password" type="password" minlength="8"
                                required>
                            <div class="invalid-feedback">Password must be of 8 characters.</div>
                        </div>
                        <div class="col-md-6"><label class="form-label" for="password_confirmation">Confirm
                                Password</label><input class="form-control" id="password_confirmation"
                                name="password_confirmation" type="password" minlength="8" required>
                            <div class="invalid-feedback">Password does not match.</div>
                        </div> --}}
                        </div>

                        <div class="d-flex flex-wrap justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" type="submit"><i class="bi bi-person-check"
                                    aria-hidden="true"></i> Update User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
@endsection
