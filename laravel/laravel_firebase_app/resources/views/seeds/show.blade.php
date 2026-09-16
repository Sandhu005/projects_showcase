@extends('layouts.dashboard')

@section('page')
    Crop Details
@endsection

@section('content')
    <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
            <div class="page-heading">
                <div class="page-heading-copy">
                    <span class="page-icon"><i class="bi bi-tree-fill" aria-hidden="true"></i></span>
                    <div>
                        <p class="eyebrow mb-1">Management</p>
                        <h1 class="h3 mb-1">Seed Details</h1>
                        <p class="text-muted mb-0">Inspect seed information, details, and related data.
                        </p>
                    </div>
                </div>

                <div class="heading-actions">
                    <a class="btn btn-outline-secondary btn-sm" href="{{ route('seeds.index') }}"><i
                            class="bi bi-arrow-left" aria-hidden="true"></i> Back to
                        Seeds List</a>

                    @can('manage seeds')
                        <a class="btn btn-primary btn-sm" href="{{ route('seeds.create') }}"><i class="bi bi-plus"
                                aria-hidden="true"></i> Add Seed</a>
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
                            <img class="avatar-img avatar-xl profile-photo"
                                src="{{ url('images/crops/' . $seed->crop->crop_image) }}" alt="{{ $seed->crop->crop_name }}">
                            <h2 class="h5 mb-1">{{ $seed->crop->crop_name }}</h2>
                            <p class="text-muted mb-3">{{ $seed->seed_name }}</p>
                            @if ($seed->status === 'active')
                                <span class="badge text-bg-success">Active</span>
                            @else
                                <span class="badge text-bg-danger">Inactive</span>
                            @endif

                            <div class="info-list mt-4 text-start">
                                <div><span>Maturity Days</span><strong>{{ $seed->maturity_days }}</strong></div>
                                <div><span>Season</span><strong>{{ $seed->season }}</strong></div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-8">
                    <div class="panel mb-3">
                        <div class="panel-header">
                            <div>
                                <h2 class="h5 mb-1 section-title"><i class="bi bi-tree-fill"
                                        aria-hidden="true"></i><span>Seed Overview</span></h2>
                                <p class="text-muted mb-0">Inspect seed information, details, and related data.</p>
                            </div>

                            @can('manage seeds')
                                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal"
                                    data-bs-target="#formModal">Edit Seed</button>
                            @endcan

                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="mini-card">
                                    <span>Seed Name</span><strong>{{ $seed->seed_name }}</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mini-card"><span>Season</span><strong>{{ $seed->season }}</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mini-card"><span>Created
                                        at</span><strong>{{ $seed->created_at->format('M j, Y') }}</strong></div>
                            </div>
                        </div>
                    </div>
                    <div class="panel">
                        <div class="panel-header">
                            <div>
                                <h2 class="h5 mb-1 section-title"><i class="bi bi-book"
                                        aria-hidden="true"></i><span>Description</span></h2>
                            </div>
                        </div>
                        <div class="activity-list">
                            <div class="activity-item">
                                <div>
                                    <p class="text-muted small mb-0">{{ $seed->seed_description ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    @can('manage seeds')
        {{-- Edit Form Model --}}
        <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form class="panel needs-validation" novalidate action="{{ route('seeds.update', $seed->id) }}"
                        method="post">
                        @csrf
                        @method('PATCH')
                        <div class="panel-header">
                            <div>
                                <h2 class="h5 mb-1 section-title"><i class="bi bi-tree" aria-hidden="true"></i><span>Update Seed
                                        Details</span></h2>
                                <p class="text-muted mb-0">Update seed information with validated fields.</p>
                            </div>
                        </div>
                        <div class="row g-3">

                            <div class="col-md-6"><label class="form-label" for="seed_name">Crop Name</label>
                                <select name="crop_id" id="crop_id" class="form-control" required>
                                    <option value="">Select a crop</option>
                                    @foreach ($crops as $crop)
                                        <option value="{{ $crop->id }}"
                                            {{ old('crop_id', $seed->crop_id) == $crop->id ? 'selected' : '' }}>
                                            {{ $crop->crop_name }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">Crop name is required.</div>
                            </div>

                            <div class="col-md-6"><label class="form-label" for="seed_name">Seed Name</label><input
                                    class="form-control" id="seed_name" name="seed_name" type="text"
                                    value="{{ old('seed_name', $seed->seed_name) }}" required>
                                <div class="invalid-feedback">Seed name is required.</div>
                            </div>

                            <div class="col-md-6"><label class="form-label" for="seed_type">Seed Type</label><input
                                    class="form-control" id="seed_type" name="seed_type" type="text"
                                    value="{{ old('seed_type', $seed->seed_type) }}" required>
                                <div class="invalid-feedback">Seed type is required.</div>
                            </div>

                            <div class="col-md-6"><label class="form-label" for="maturity_days">Maturity Days</label><input
                                    class="form-control" id="maturity_days" name="maturity_days" type="number"
                                    value="{{ old('maturity_days', $seed->maturity_days) }}" required>
                                <div class="invalid-feedback">Maturity days are required.</div>
                            </div>

                            <div class="col-md-6"><label class="form-label" for="season">Season</label>
                                <select name="season" id="season" class="form-control" required>
                                    <option value="">Select a season</option>
                                    <option value="kharif" {{ old('season', $seed->season) == 'kharif' ? 'selected' : '' }}>
                                        Kharif Season
                                    </option>
                                    <option value="rabi" {{ old('season', $seed->season) == 'rabi' ? 'selected' : '' }}>Rabi
                                        Season
                                    </option>
                                    <option value="zaid" {{ old('season', $seed->season) == 'zaid' ? 'selected' : '' }}>Zaid
                                        Season
                                    </option>
                                    <option value="off season"
                                        {{ old('season', $seed->season) == 'off season' ? 'selected' : '' }}>Off
                                        Season</option>
                                </select>
                                <div class="invalid-feedback">Season is required.</div>
                            </div>

                            <div class="col-md-6"><label class="form-label" for="seed_description">Seed Description</label>
                                <textarea class="form-control" id="seed_description" name="seed_description" rows="3">{{ old('seed_description', $seed->seed_description) }}</textarea>
                                <div class="invalid-feedback">Seed description is optional.</div>
                            </div>

                        </div>

                        <div class="d-flex flex-wrap justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" type="submit"><i class="bi bi-tree" aria-hidden="true"></i>
                                Update Seed</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
@endsection
