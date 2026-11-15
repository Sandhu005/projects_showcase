@extends('layouts.dashboard')

@section('page')
    Advisory Details
@endsection

@section('content')
    <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
            <div class="page-heading">
                <div class="page-heading-copy">
                    <span class="page-icon"><i class="bi bi-bell-fill" aria-hidden="true"></i></span>
                    <div>
                        <p class="eyebrow mb-1">Management</p>
                        <h1 class="h3 mb-1">Advisory Details</h1>
                        <p class="text-muted mb-0">View advisory title, description, validity period, and more.
                        </p>
                    </div>
                </div>

                <div class="heading-actions">
                    <a class="btn btn-outline-secondary btn-sm" href="{{ route('advisories.index') }}"><i
                            class="bi bi-arrow-left" aria-hidden="true"></i> Back to
                        Advisory List</a>

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
                            <h2 class="h5 mb-1">{{ $advisory->title_en }}</h2>
                            <p class="text-muted mb-3">{{ $advisory->title_hi }}</p>
                            @if ($advisory->valid_from <= now() && $advisory->valid_until >= now())
                                <span class="badge bg-success">Active</span>
                            @elseif ($advisory->valid_from > now())
                                <span class="badge bg-warning">Upcoming</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </div>
                        <div class="info-list mt-4 text-start">
                            <div><span>Created By</span><strong>{{ $advisory->creator->name }}</strong></div>
                            @if ($advisory->updated_by !== null)
                                <div><span>Update By</span><strong>{{ $advisory->updater->name }}</strong></div>
                            @endif
                            {{-- <div><span>State</span><strong> {{ $advisory->state ?? '-' }}</strong></div> --}}
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-8">
                    <div class="panel mb-3">
                        <div class="panel-header">
                            <div>
                                <h2 class="h5 mb-1 section-title"><i class="bi bi-bell-fill"
                                        aria-hidden="true"></i><span>Advisory Overview</span></h2>
                                <p class="text-muted mb-0">Description, created by, and validity details.</p>
                            </div>

                            @can('manage advisories')
                                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal"
                                    data-bs-target="#formModal">Edit Advisory</button>
                            @endcan

                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="mini-card">
                                    <span>State</span><strong>{{ $advisory->state ?? '-' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mini-card"><span>Valid
                                        From</span><strong>{{ $advisory->valid_from->format('d-m-y') }}</strong></div>
                            </div>
                            <div class="col-md-4">
                                <div class="mini-card"><span>Valid
                                        Until</span><strong>{{ $advisory->valid_until->format('d-m-y') }}</strong></div>
                            </div>
                        </div>
                    </div>
                    <div class="panel">
                        <div class="panel-header">
                            <div>
                                <h2 class="h5 mb-1 section-title"><i class="bi bi-book"
                                        aria-hidden="true"></i><span>Description</span></h2>
                                <p class="text-muted mb-0">Advisory message, notification, description.</p>
                            </div>
                        </div>
                        <div class="activity-list">
                            <div class="activity-item"><span class="activity-dot bg-primary"></span>
                                <div>
                                    <p class="mb-1 fw-semibold">English</p>
                                    <p class="text-muted small mb-0">{{ $advisory->description_en }}</p>
                                </div>
                            </div>
                            <div class="activity-item"><span class="activity-dot bg-success"></span>
                                <div>
                                    <p class="mb-1 fw-semibold">Hindi</p>
                                    <p class="text-muted small mb-0">{{ $advisory->description_hi }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    @can('manage advisories')
        {{-- Edit Form Model --}}
        <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <form class="panel needs-validation" novalidate action="{{ route('advisories.update', $advisory->id) }}"
                        method="post">
                        @csrf
                        @method('PATCH')
                        <div class="panel-header">
                            <div>
                                <h2 class="h5 mb-1 section-title"><i class="bi bi-bell" aria-hidden="true"></i><span>Update
                                        Advisory Details</span></h2>
                            </div>
                            <div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label" for="title_en">English Title</label><input
                                    class="form-control" id="title_en" name="title_en" type="text"
                                    value="{{ old('title_en', $advisory->title_en) }}" required>
                                <div class="invalid-feedback">Title is required.</div>
                            </div>

                            <div class="col-md-6"><label class="form-label" for="title_hi">Hindi Title</label><input
                                    class="form-control" id="title_hi" name="title_hi" type="text"
                                    value="{{ old('title_hi', $advisory->title_hi) }}" required>
                                <div class="invalid-feedback">Title is required.</div>
                            </div>

                            {{-- <div class="col-md-6"><label class="form-label" for="state">State</label>
                                <select name="state" id="state" class="form-control">
                                    <option value="">Select a state</option>
                                    <option value="Himachal Pradesh"
                                        {{ old('state', $advisory->state) == 'Himachal Pradesh' ? 'selected' : '' }}>Himachal
                                        Pradesh
                                    </option>
                                    <option value="Uttarakhand"
                                        {{ old('state', $advisory->state) == 'Uttarakhand' ? 'selected' : '' }}>Uttarakhand
                                    </option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div> --}}

                            <div class="col-md-6"><label class="form-label" for="valid_from">Valid From</label><input
                                    class="form-control" id="valid_from" name="valid_from" type="date"
                                    value="{{ old('valid_from', $advisory->valid_from->format('Y-m-d')) }}">
                                <div class="invalid-feedback">Invalid Date Format.</div>
                            </div>

                            <div class="col-md-6"><label class="form-label" for="valid_until">Valid Until</label><input
                                    class="form-control" id="valid_until" name="valid_until" type="date"
                                    value="{{ old('valid_until', $advisory->valid_until->format('Y-m-d')) }}">
                                <div class="invalid-feedback">Invalid Date.</div>
                            </div>

                            <div class="col-md-6"><label class="form-label" for="description_en">English Description</label>
                                <textarea class="form-control" id="description_en" name="description_en" rows="3" required>{{ old('description-en', $advisory->description_en) }}</textarea>
                                <div class="invalid-feedback">description is required.</div>
                            </div>

                            <div class="col-md-6"><label class="form-label" for="description_hi">Hindi Description</label>
                                <textarea class="form-control" id="description_hi" name="description_hi" rows="3" required>{{ old('description-hi', $advisory->description_hi) }}</textarea>
                                <div class="invalid-feedback">description is required.</div>
                            </div>

                        </div>

                        <div class="d-flex flex-wrap justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" type="submit"><i class="bi bi-bell" aria-hidden="true"></i>
                                Update Advisory</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
@endsection
