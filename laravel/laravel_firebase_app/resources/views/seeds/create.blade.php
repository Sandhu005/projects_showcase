@extends('layouts.dashboard')

@section('page')
    Add Seed
@endsection

@section('content')

    <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
            <div class="page-heading">
                <div class="page-heading-copy">
                    <span class="page-icon"><i class="bi bi-tree" aria-hidden="true"></i></span>
                    <div>
                        <p class="eyebrow mb-1">Management</p>
                        <h1 class="h3 mb-1">Add Seed</h1>
                        <p class="text-muted mb-0">Create a new Seed with description.</p>
                    </div>
                </div>
                <div class="heading-actions"><a class="btn btn-outline-secondary btn-sm"
                        href="{{ route('seeds.index') }}"><i class="bi bi-arrow-left" aria-hidden="true"></i> Back to
                        Seeds List</a>
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
                    <form class="panel needs-validation" novalidate action="{{ route('seeds.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="panel-header">
                            <div>
                                <h2 class="h5 mb-1 section-title"><i class="bi bi-tree" aria-hidden="true"></i><span>Seed
                                        Details</span></h2>
                                <p class="text-muted mb-0">Create a new seed with the following information.</p>
                            </div>
                        </div>

                        <div class="row g-3">

                            <div class="col-md-6"><label class="form-label" for="seed_name">Crop Name</label>
                                <select name="crop_id" id="crop_id" class="form-control" required>
                                    <option value="">Select a crop</option>
                                    @foreach ($crops as $crop)
                                        <option value="{{ $crop->id }}"
                                            {{ old('crop_id') == $crop->id ? 'selected' : '' }}>
                                            {{ $crop->crop_name }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">Crop name is required.</div>
                            </div>

                            <div class="col-md-6"><label class="form-label" for="seed_name">Seed Name</label><input
                                    class="form-control" id="seed_name" name="seed_name" type="text"
                                    value="{{ old('seed_name') }}" required>
                                <div class="invalid-feedback">Seed name is required.</div>
                            </div>

                            <div class="col-md-6"><label class="form-label" for="seed_type">Seed Type</label><input
                                    class="form-control" id="seed_type" name="seed_type" type="text"
                                    value="{{ old('seed_type') }}" required>
                                <div class="invalid-feedback">Seed type is required.</div>
                            </div>

                            <div class="col-md-6"><label class="form-label" for="maturity_days">Maturity Days</label><input
                                    class="form-control" id="maturity_days" name="maturity_days" type="number"
                                    value="{{ old('maturity_days') }}" required>
                                <div class="invalid-feedback">Maturity days are required.</div>
                            </div>

                            <div class="col-md-6"><label class="form-label" for="season">Season</label>
                                <select name="season" id="season" class="form-control" required>
                                    <option value="">Select a season</option>
                                    <option value="kharif" {{ old('season') == 'kharif' ? 'selected' : '' }}>Kharif Season
                                    </option>
                                    <option value="rabi" {{ old('season') == 'rabi' ? 'selected' : '' }}>Rabi Season
                                    </option>
                                    <option value="zaid" {{ old('season') == 'zaid' ? 'selected' : '' }}>Zaid Season
                                    </option>
                                    <option value="off season" {{ old('season') == 'off season' ? 'selected' : '' }}>Off
                                        Season</option>
                                </select>
                                <div class="invalid-feedback">Season is required.</div>
                            </div>

                            <div class="col-md-6"><label class="form-label" for="seed_description">Seed Description</label>
                                <textarea class="form-control" id="seed_description" name="seed_description" rows="3">{{ old('seed_description') }}</textarea>
                                <div class="invalid-feedback">Seed description is optional.</div>
                            </div>

                        </div>

                        <div class="d-flex flex-wrap justify-content-end gap-2 mt-4"><a class="btn btn-outline-secondary"
                                href="users.html">Cancel</a><button class="btn btn-primary" type="submit"><i
                                    class="bi bi-tree" aria-hidden="true"></i> Add Seed</button>
                        </div>
                    </form>
                </div>
                <div class="col-12 col-xl-4">
                    <div class="panel h-100">
                        <h2 class="h5 mb-3 section-title"><i class="bi bi-list-check" aria-hidden="true"></i><span>Seeds
                                Checklist</span></h2>
                        <div class="activity-list">
                            <div class="activity-item"><span class="activity-dot bg-primary"></span>
                                <div>
                                    <p class="mb-1 fw-semibold">Fill Details</p>
                                    <p class="text-muted small mb-0">Required fields must be filled.</p>
                                </div>
                            </div>

                            <div class="activity-item"><span class="activity-dot bg-success"></span>
                                <div>
                                    <p class="mb-1 fw-semibold">Description is optional</p>
                                    <p class="text-muted small mb-0">Provide additional information about the seed.</p>
                                </div>
                            </div>

                            <div class="activity-item"><span class="activity-dot bg-warning"></span>
                                <div>
                                    <p class="mb-1 fw-semibold">Avoid Duplicates</p>
                                    <p class="text-muted small mb-0">Ensure the crop seed is unique.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

@endsection
