@extends('layouts.dashboard')

@section('page')
    Alert Details
@endsection

@section('content')
    <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
            <div class="page-heading">
                <div class="page-heading-copy">
                    <span class="page-icon"><i class="bi bi-exclamation-triangle" aria-hidden="true"></i></span>
                    <div>
                        <p class="eyebrow mb-1">Management</p>
                        <h1 class="h3 mb-1">Alert Details</h1>
                        <p class="text-muted mb-0">View alert title, description, validity period, and more.</p>
                    </div>
                </div>
                <div class="heading-actions">
                    <a class="btn btn-outline-secondary btn-sm" href="{{ route('alerts.index') }}"><i
                            class="bi bi-arrow-left" aria-hidden="true"></i> Back to Alerts List</a>

                    @can('manage alerts')
                        <a class="btn btn-primary btn-sm" href="{{ route('advisories.create') }}"><i class="bi bi-plus"
                                aria-hidden="true"></i> Create Advisory</a>
                    @endcan
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <section class="row g-3">
                <div class="col-12 col-xl-4">
                    <div class="panel h-100 text-center profile-card">
                        <div class="profile-cover"><img src="{{ url('images/png/dasher-ui-bootstrap-5.jpg') }}"
                                alt="User workspace preview"></div>
                        <div class="profile-hero">
                            <h2 class="h5 mb-1">{{ $alert->title_en }}</h2>
                            <p class="text-muted mb-3">{{ $alert->title_hi }}</p>
                            @if ($alert->valid_from <= now() && $alert->valid_until >= now())
                                <span class="badge bg-success">Active</span>
                            @elseif ($alert->valid_from > now())
                                <span class="badge bg-warning">Upcoming</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </div>
                        <div class="info-list mt-4 text-start">
                            <div><span>Created By</span><strong>{{ $alert->creator?->name ?? '-' }}</strong></div>
                            @if ($alert->updated_by !== null)
                                <div><span>Update By</span><strong>{{ $alert->updater?->name ?? '-' }}</strong></div>
                            @endif
                            {{-- <div><span>State</span><strong> {{ $alert->state ?? '-' }}</strong></div> --}}
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-8">
                    <div class="panel mb-3">
                        <div class="panel-header">
                            <div>
                                <h2 class="h5 mb-1">Alert Overview</h2>
                                <p class="text-muted mb-0">Location and validity period.</p>
                            </div>
                            @can('manage alerts')
                                @unless ($alert->trashed())
                                    <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal"
                                        data-bs-target="#alertEditModal">Edit Alert</button>
                                @endunless
                            @endcan
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="mini-card">
                                    <span>State</span><strong>{{ $alert->state ?? '-' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mini-card"><span>Valid
                                        From</span><strong>{{ $alert->valid_from?->format('d-m-Y') ?? 'No start date' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mini-card"><span>Valid
                                        Until</span><strong>{{ $alert->valid_until?->format('d-m-Y') ?? 'No end date' }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-header">
                            <div>
                                <h2 class="h5 mb-1 section-title"><i class="bi bi-book"
                                        aria-hidden="true"></i><span>Description</span></h2>
                                <p class="text-muted mb-0">Alert message, notification, description.</p>
                            </div>
                        </div>
                        <div class="activity-list">
                            <div class="activity-item"><span class="activity-dot bg-primary"></span>
                                <div>
                                    <p class="mb-1 fw-semibold">English</p>
                                    <p class="text-muted small mb-0">{{ $alert->description_en }}</p>
                                </div>
                            </div>
                            <div class="activity-item"><span class="activity-dot bg-success"></span>
                                <div>
                                    <p class="mb-1 fw-semibold">Hindi</p>
                                    <p class="text-muted small mb-0">{{ $alert->description_hi }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    @can('manage alerts')
        @unless ($alert->trashed())
            <div class="modal fade" id="alertEditModal" tabindex="-1" aria-labelledby="alertEditModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <form action="{{ route('alerts.update', $alert->id) }}" method="post">
                            @csrf
                            @method('PATCH')
                            <div class="modal-header d-flex justify-content-between">
                                <div>
                                    <h2 class="h5 mb-1 section-title"><i class="bi bi-exclamation-triangle"
                                            aria-hidden="true"></i><span>Update
                                            Alert Details</span></h2>
                                </div>
                                <div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="alert-title_en">English Title</label>
                                        <input class="form-control" id="alert-title_en" name="title_en" type="text"
                                            value="{{ old('title_en', $alert->title_en) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="alert-title_hi">Hindi Title</label>
                                        <input class="form-control" id="alert-title_hi" name="title_hi" type="text"
                                            value="{{ old('title_hi', $alert->title_hi) }}" required>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <label class="form-label" for="alert-state">State</label>
                                        <select name="state" id="alert-state" class="form-control">
                                            <option value="">Select a state</option>
                                            <option value="Himachal Pradesh"
                                                {{ old('state', $alert->state) == 'Himachal Pradesh' ? 'selected' : '' }}>
                                                Himachal Pradesh
                                            </option>
                                            <option value="Uttarakhand"
                                                {{ old('state', $alert->state) == 'Uttarakhand' ? 'selected' : '' }}>
                                                Uttarakhand
                                            </option>
                                        </select>
                                    </div> --}}
                                    <div class="col-md-6">
                                        <label class="form-label" for="alert-valid-from">Valid From</label>
                                        <input class="form-control" id="alert-valid-from" name="valid_from" type="date"
                                            value="{{ old('valid_from', $alert->valid_from?->format('Y-m-d')) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="alert-valid-until">Valid Until</label>
                                        <input class="form-control" id="alert-valid-until" name="valid_until" type="date"
                                            value="{{ old('valid_until', $alert->valid_until?->format('Y-m-d')) }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label" for="alert-description_en">English Description</label>
                                        <textarea class="form-control" id="alert-description_en" name="description_en" rows="4" required>{{ old('description_en', $alert->description_en) }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label" for="alert-description_hi">Hindi Description</label>
                                        <textarea class="form-control" id="alert-description_hi" name="description_hi" rows="4" required>{{ old('description_hi', $alert->description_hi) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary" type="submit"><i class="bi bi-exclamation-triangle"
                                        aria-hidden="true"></i>Update Alert</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endunless
    @endcan
@endsection
