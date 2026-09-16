@extends('layouts.dashboard')

@section('page')
    Add User
@endsection

@section('content')
    <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
            <div class="page-heading">
                <div class="page-heading-copy">
                    <span class="page-icon"><i class="bi bi-person-plus" aria-hidden="true"></i></span>
                    <div>
                        <p class="eyebrow mb-1">Management</p>
                        <h1 class="h3 mb-1">Add User</h1>
                        <p class="text-muted mb-0">Create a new user account with role assignments.</p>
                    </div>
                </div>
                <div class="heading-actions"><a class="btn btn-outline-secondary btn-sm"
                        href="{{ route('users.index') }}"><i class="bi bi-arrow-left" aria-hidden="true"></i> Back to
                        Users</a>
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
                            <li> {{ $error }} </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <section class="row g-3">
                <div class="col-12 col-xl-8">
                    <form class="panel needs-validation" novalidate action="{{ route('users.store') }}" method="post">
                        @csrf
                        <div class="panel-header">
                            <div>
                                <h2 class="h5 mb-1 section-title"><i class="bi bi-person-plus"
                                        aria-hidden="true"></i><span>User Information</span></h2>
                                <p class="text-muted mb-0">Create a user account with validated fields.</p>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label" for="name">Name</label><input
                                    class="form-control" id="name" name="name" type="text"
                                    value="{{ old('name') }}" required>
                                <div class="invalid-feedback">Name is required.</div>
                            </div>

                            <div class="col-md-6"><label class="form-label" for="email">Email</label><input
                                    class="form-control" id="email" name="email" type="email"
                                    value="{{ old('email') }}" required>
                                <div class="invalid-feedback">Enter a valid email.</div>
                            </div>
                            <div class="col-md-6"><label class="form-label" for="phone">Phone</label><input
                                    class="form-control" id="phone" name="phone" type="tel" max="10"
                                    pattern="[6-9][0-9]{9}" value="{{ old('phone') }}" required>
                                <div class="invalid-feedback">Invalid Number.</div>
                            </div>
                            <div class="col-md-6"><label class="form-label" for="role">Role</label><select
                                    class="form-select" id="role" name="role" required>
                                    <option value="">Choose role</option>
                                    <option value="admin" @selected(old('role') == 'admin')>Admin</option>
                                    <option value="editor" @selected(old('role') == 'editor')>Editor</option>
                                </select>
                                <div class="invalid-feedback">Choose a role.</div>
                            </div>
                            <div class="col-md-6"><label class="form-label" for="password">Password</label><input
                                    class="form-control" id="password" name="password" type="password" minlength="8"
                                    required>
                                <div class="invalid-feedback">Password must be of 8 characters.</div>
                            </div>
                            <div class="col-md-6"><label class="form-label" for="password_confirmation">Confirm
                                    Password</label><input class="form-control" id="password_confirmation"
                                    name="password_confirmation" type="password" minlength="8" required>
                                <div class="invalid-feedback">Password does not match.</div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap justify-content-end gap-2 mt-4"><a class="btn btn-outline-secondary"
                                href="users.html">Cancel</a><button class="btn btn-primary" type="submit"><i
                                    class="bi bi-person-check" aria-hidden="true"></i> Create User</button>
                        </div>
                    </form>
                </div>
                <div class="col-12 col-xl-4">
                    <div class="panel h-100">
                        <h2 class="h5 mb-3 section-title"><i class="bi bi-list-check" aria-hidden="true"></i><span>Users Checklist</span></h2>
                        <div class="activity-list">
                            <div class="activity-item"><span class="activity-dot bg-primary"></span>
                                <div>
                                    <p class="mb-1 fw-semibold">Fill Details</p>
                                    <p class="text-muted small mb-0">All details are mandatory.</p>
                                </div>
                            </div>

                            <div class="activity-item"><span class="activity-dot bg-success"></span>
                                <div>
                                    <p class="mb-1 fw-semibold">Assign role</p>
                                    <p class="text-muted small mb-0">Start with the least privileged role.</p>
                                </div>
                            </div>

                            <div class="activity-item"><span class="activity-dot bg-warning"></span>
                                <div>
                                    <p class="mb-1 fw-semibold">Send invite</p>
                                    <p class="text-muted small mb-0">Users receive activation by email.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection
